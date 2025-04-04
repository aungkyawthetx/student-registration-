<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
