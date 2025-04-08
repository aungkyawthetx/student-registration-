<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrollmentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['student_name', 'course_name', 'enrollment_date'];

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
        $course = Course::where('name', $row['course_name'])->first();
        if (!$course) {
            throw ValidationException::withMessages([
                'file' => "Invalid course specified: " . $row['course_name']
            ]);
        }
        return new Enrollment([
            'student_id' => $student ? $student->id : null,
            'course_id' => $course ? $course->id : null,
            'date' => $row['enrollment_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
