<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\ClassTimeTable;
use App\Models\Course;
use App\Models\Room;
use App\Models\Student;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class AttendancesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['class_name', 'student_name', 'date', 'status'];

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
        
        $class = ClassTimeTable::where('name', $row['class_name'])->first();
        if (!$class) {
            throw ValidationException::withMessages([
                'file' => "Invalid course specified: " . $row['class_name']
            ]);
        }

        return new Attendance([
            'class_id' => $class ? $class->id : null,
            'student_id' => $student ? $student->id : null,
            'attendance_date' => is_numeric($row['date'])
                ? Date::excelToDateTimeObject($row['date'])->format('Y-m-d')
                : Carbon::parse($row['date'])->format('Y-m-d'),
            'attendance_status' => $row['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
