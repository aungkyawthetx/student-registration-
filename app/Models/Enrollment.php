<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use App\Models\ClassTimeTable;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassTimeTable::class);
    }
}
