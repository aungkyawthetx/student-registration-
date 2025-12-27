<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\ClassTimeTable;
use App\Models\Course;
use App\Models\Enrollment;
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
        $headers = ['class_name', 'start_date', 'time', 'student_name', 'date', 'status'];

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
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('class_id', $class->id)
            ->first();
        if (!$enrollment) {
            throw ValidationException::withMessages([
                'file' => "Student '{$student->name}' is not enrolled in class '{$course->name}'"
            ]);
        }
        
        $attendanceDate = is_numeric($row['date'])
            ? Date::excelToDateTimeObject($row['date'])->format('Y-m-d')
            : Carbon::parse($row['date'])->format('Y-m-d');
        
        if ($attendanceDate < $enrollment->date) {
            throw ValidationException::withMessages([
                'file' => "Invalid attendance date for student '{$student->name}' — attendance date '{$attendanceDate}' is before enrollment date '{$enrollment->date}'"
            ]);
        }
        if ($attendanceDate > $class->end_date) {
            throw ValidationException::withMessages([
                'file' => "Invalid attendance date for '{$student->name}'. Attendance date '{$attendanceDate}' is after class end date '{$class->end_date}'."
            ]);
        }
        return new Attendance([
            'class_id' => $class ? $class->id : null,
            'student_id' => $student ? $student->id : null,
            'attendance_date' => $attendanceDate,
            'attendance_status' => $row['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
