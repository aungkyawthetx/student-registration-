<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTimeTable extends Model
{
    protected $guarded = [];
    protected $table = 'classes';

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
