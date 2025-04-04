<?php

namespace App\Models;

use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'course_id');
    }
}
