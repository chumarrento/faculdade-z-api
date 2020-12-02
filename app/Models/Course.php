<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function getDisciplinesBySemester(int $semester): Collection
    {
        return $this->disciplines()->wherePivot('semester', $semester)->get();
    }
}
