<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = collect([
            [
                'name' => 'Lucas Pereira',
                'cpf' => '00000000000',
                'email' => 'lucasp28.contato@gmail.com',
                'email_verified_at' => now(),
                'registration' => '01227941',
                'password' => 'secret',
                'current_semester' => 8,
                'course_id' => 1
            ],
            [
                'name' => 'Aluno 2',
                'cpf' => '00000000001',
                'email' => 'aluno@gmail.com',
                'email_verified_at' => null,
                'registration' => '01227942',
                'password' => 'secret',
                'current_semester' => 5,
                'course_id' => 1
            ],
        ]);
        Student::truncate();

        $students->each(function($student) {
            Student::create($student);
        });
    }
}
