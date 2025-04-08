<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\TeacherCourse;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherCoursesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['teacher_name', 'course'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        $teacher = Teacher::where('name', $row['teacher_name'])->first();
        if (!$teacher) {
            throw ValidationException::withMessages([
                'file' => "Invalid teacher specified: " . $row['teacher_name']
            ]);
        }
        $course = Course::where('name', $row['course'])->first();
        if (!$course) {
            throw ValidationException::withMessages([
                'file' => "Invalid course specified: " . $row['course']
            ]);
        }
        return new TeacherCourse([
            'teacher_id' => $teacher ? $teacher->id : null,
            'course_id' => $course ? $course->id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
