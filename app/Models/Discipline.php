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

    protected $with = ['difficulty'];
    protected $appends = ['schedule'];

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

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'disciplines_students',
            'discipline_id',
            'student_id'
        )
        ->withPivot(['status', 'final_grade'])
        ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'discipline_id', 'id');
    }

    public function addSchedule(array $scheduleAttributes): void
    {
        $this->schedules()->create($scheduleAttributes);
    }

    public function getScheduleAttribute()
    {
        return $this->schedules()->first();
    }
}
