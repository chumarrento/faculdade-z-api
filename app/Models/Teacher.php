<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function disciplines()
    {
        return $this->hasMany(Discipline::class, 'teacher_id', 'id');
    }
}
