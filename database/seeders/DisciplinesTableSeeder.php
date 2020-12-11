<?php

namespace Database\Seeders;

use App\Enums\Difficulties;
use App\Models\Discipline;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DisciplinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachersCount = Teacher::all()->count();

        $disciplines = collect([
            [
                'name' => 'Cenários de TI',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Planejamento de carreira',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Fundamentos de redes de computadores',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Introdução a lógica de programação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Organização e arquitetura de computadores',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Tecnologia para internet',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Fundamentos de sistemas de informação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Inovação tecnológica e empreendedorismo',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Língua portuguesa',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Matemática aplicada a computação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Modelagem de dados',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Engenharia de usabilidade e interfaces',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Estrutura de dados',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ],
            [
                'name' => 'Processos de desenvolvimento de software',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Requisitos de sistema',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Sistemas Operacionais',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Algoritmos Avançados',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ],
            [
                'name' => 'Fundamentos de pesquisa operaciona',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Modelagem de sistemas',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Probabilidade de estatística',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Programação I',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Qualidade de software',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Arquitetura de sistemas',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Fundamentos de gestão de TI',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Multimídia para internet',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Padrões de projeto de software',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Programação II',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ],
            [
                'name' => 'Tecnologias para internet II',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Auditoria de sistemas',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Gestão de infraestrutura',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::EASY
            ],
            [
                'name' => 'Gestão de projetos de TI',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Programação para dispositivos móveis',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ],
            [
                'name' => 'Projeto em sistemas de informação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Gestão em segurança de informação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Implementação de banco de dados',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ],
            [
                'name' => 'Programação III',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ],
            [
                'name' => 'Projeto de TCC em sistemas de informação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Testes de software',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'Seminários integrados em sistemas de informação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::MEDIUM
            ],
            [
                'name' => 'TCC em sistemas de informação',
                'teacher_id' => rand(1, $teachersCount),
                'difficulty_id' => Difficulties::HARD
            ]
        ]);

        Discipline::truncate();
        $disciplines->each(function ($discipline) {
            Discipline::create($discipline);
        });
    }
}
