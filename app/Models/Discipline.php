<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'difficulty_id',
        'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class, 'difficulty_id', 'id');
    }

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'courses_disciplines',
            'discipline_id',
            'course_id'
        )
        ->withPivot('semester')
        ->withTimestamps();

    }
}
