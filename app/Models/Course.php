<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_courses');
    }
}
