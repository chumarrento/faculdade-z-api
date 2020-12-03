<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
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

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

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

    public function studentTokens()
    {
        return $this->hasMany(StudentToken::class, 'student_id', 'id');
    }

    public function addFeedback(string $message): void
    {
        $this->supportContacts()->create([
            'message' => $message
        ]);
    }

    public function getCurrentSemesterInfo(): Collection
    {
        $disciplines = $this->course->getDisciplinesBySemester($this->current_semester);

        return $disciplines->map(function ($discipline) {
            $studentDisciplineInfo = $this->getStudentDisciplineInfo($discipline->id);

            return [
                'discipline_name' => $discipline->name,
                'discipline_difficulty' => $discipline->difficulty->name,
                'discipline_teacher' => $discipline->teacher->name,
                'discipline_schedule' => [
                    'weekday' => $discipline->schedule->weekday,
                    'start_time' => $discipline->schedule->start_time,
                    'end_time' => $discipline->schedule->end_time,
                ],
                'status' => $studentDisciplineInfo->pivot->status,
                'final_grade' => $studentDisciplineInfo->pivot->final_grade
            ];
        });
    }

    public function getStudentDisciplineInfo(int $disciplineId): Discipline
    {
        return $this->disciplines()->where('discipline_id', $disciplineId)->first();
    }

    public function getSchoolRecord(): Collection
    {
        $disciplinesTaken = $this->course->getPreviousDisciplinesBySemester($this->current_semester);

        return $disciplinesTaken->map(function ($discipline) {
            $studentDisciplineInfo = $this->getStudentDisciplineInfo($discipline->id);

            return [
                'discipline_name' => $discipline->name,
                'discipline_teacher' => $discipline->teacher->name,
                'status' => $studentDisciplineInfo->pivot->status,
                'final_grade' => $studentDisciplineInfo->pivot->final_grade
            ];
        });
    }
}
