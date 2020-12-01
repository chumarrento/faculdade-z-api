<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'email_verified_at',
        'registration',
        'current_semester',
        'course_id'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['course'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function getCourseAttribute()
    {
        return $this->course()->getResults();
    }

    public function disciplines()
    {
        return $this->belongsToMany(
            Discipline::class,
            'disciplines_students',
            'student_id',
            'discipline_id'
        )
            ->withPivot(['status', 'final_grade'])
            ->withTimestamps();
    }

    public function supportContacts()
    {
        return $this->hasMany(Support::class, 'student_id', 'id');
    }

    public function addFeedback(string $message): void
    {
        $this->supportContacts()->create([
            'message' => $message
        ]);
    }

    public function getCurrentSemesterInfo()
    {
        $disciplines = $this->course->disciplines()->wherePivot('semester', $this->current_semester)->get();

        return $disciplines->map(function ($discipline) {
            $studentDisciplineInfo = $this->disciplines()->where('discipline_id', $discipline->id)->first();

            return [
                'discipline_name' => $discipline->name,
                'discipline_difficulty' => $discipline->difficulty->name,
                'discipline_teacher' => $discipline->teacher->name,
                'discipline_schedule' => [
                    'weekday' => $discipline->schedule->weekday,
                    'start_time' => $discipline->schedule->start_time,
                    'end_time' => $discipline->schedule->end_time,
                ],
                'status' => $studentDisciplineInfo->status,
                'final_grade' => $studentDisciplineInfo->final_grade
            ];
        });
    }
}
