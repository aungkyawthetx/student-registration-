<?php

namespace App\Models;

use App\Models\Attendance;
use App\Models\ClassTimeTable;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'building',
        'name'
    ];

    public function ClassTimeTable()
    {
        return $this->hasMany(ClassTimeTable::class, 'room_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'room_id');
    }
}
