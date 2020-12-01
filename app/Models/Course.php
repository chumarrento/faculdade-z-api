<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'semesters'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id', 'id');
    }

    public function disciplines()
    {
        return $this->belongsToMany(
            Discipline::class,
            'courses_disciplines',
            'course_id',
            'discipline_id'
        )
        ->withPivot('semester')
        ->withTimestamps();

    }
}
