<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekday',
        'start_time',
        'end_time',
        'discipline_id'
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id', 'id');
    }

    public function getStartTimeAttribute()
    {
        return Carbon::parse($this->attributes['start_time'])->format('h:i');
    }

    public function getEndTimeAttribute()
    {
        return Carbon::parse($this->attributes['end_time'])->format('h:i');
    }
}
