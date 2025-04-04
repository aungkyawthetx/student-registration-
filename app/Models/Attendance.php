<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Course;
use App\Models\Student;
use App\Models\ClassTimeTable;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    public function student() 
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
