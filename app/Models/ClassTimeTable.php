<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTimeTable extends Model
{
    protected $fillable = [
        'room_id',
        'date',
        'start_time',
        'end_time',
    ];
}
