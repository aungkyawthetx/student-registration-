<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTimeTable extends Model
{
    protected $guarded = [];
    protected $table = 'class_timetables';

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
