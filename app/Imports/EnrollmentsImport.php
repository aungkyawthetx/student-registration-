<?php

namespace App\Imports;

use App\Models\ClassTimeTable;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EnrollmentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['student_name', 'class_name', 'start_date', 'time', 'enrollment_date'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        $student = Student::where('name', $row['student_name'])->first();
        if (!$student) {
            throw ValidationException::withMessages([
                'file' => "Invalid student specified: " . $row['student_name']
            ]);
        }
        $course = Course::where('name', $row['class_name'])->first();
        $startDate = is_numeric($row['start_date'])
        ? Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d')
        : Carbon::parse($row['start_date'])->format('Y-m-d');
        $class = ClassTimeTable::where('course_id', $course->id)
                    ->where('start_date', $startDate)
                    ->where('time', $row['time'])
                    ->first();
        if (!$class) {
            throw ValidationException::withMessages([
                'file' => "Invalid class specified: " . $row['class_name'] . ". Please check if class start date and time are correct too."
            ]);
        }
        $enrollmentDate = is_numeric($row['enrollment_date'])
            ? Date::excelToDateTimeObject($row['enrollment_date'])->format('Y-m-d')
            : Carbon::parse($row['enrollment_date'])->format('Y-m-d');

        if ($enrollmentDate > $class->end_date) {
            throw ValidationException::withMessages([
                'file' => "Enrollment date '{$enrollmentDate}' for '{$student->name}' is after class end date '{$class->end_date}'."
            ]);
        }
        return new Enrollment([
            'student_id' => $student ? $student->id : null,
            'class_id' => $class ? $class->id : null,
            'date' => $enrollmentDate,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
