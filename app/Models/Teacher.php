<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_courses');
    }
}
