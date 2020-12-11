<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = collect([
            [
                'name' => "Patrick Peters"
            ],
            [
                'name' => "Owen Hubbard"
            ],
            [
                'name' => "Wallace Atkins"
            ],
            [
                'name' => "Kane Cervantes"
            ],
            [
                'name' => "Sylvester Poole"
            ],
            [
                'name' => "Steven Schultz"
            ],
            [
                'name' => "Lars Gibbs"
            ],
            [
                'name' => "Brody Caldwell"
            ],
            [
                'name' => "Calvin Romero"
            ],
            [
                'name' => "Grant Reese"
            ],
            [
                'name' => "Ulysses Deleon"
            ],
            [
                'name' => "Dolan Hopper"
            ],
            [
                'name' => "Cullen Ruiz"
            ],
            [
                'name' => "Amir Fitzgerald"
            ],
            [
                'name' => "Alexander Martin"
            ],
            [
                'name' => "Hyatt Morales"
            ],
            [
                'name' => "Tobias Davenport"
            ],
            [
                'name' => "Sawyer Brewer"
            ],
            [
                'name' => "Camden Monroe"
            ],
            [
                'name' => "Thaddeus Pugh"
            ],
            [
                'name' => "Rajah Clemons"
            ],
            [
                'name' => "Harrison Johnston"
            ],
            [
                'name' => "Chaney Bowers"
            ],
            [
                'name' => "Brandon Reynolds"
            ],
            [
                'name' => "Erich Orr"
            ],
            [
                'name' => "Conan Matthews"
            ],
            [
                'name' => "Mannix Flowers"
            ],
            [
                'name' => "Macaulay Gay"
            ],
            [
                'name' => "Garth Turner"
            ],
            [
                'name' => "Abel Rich"
            ],
            [
                'name' => "Vance Baxter"
            ],
            [
                'name' => "Hoyt Blair"
            ],
            [
                'name' => "Damian Gonzalez"
            ],
            [
                'name' => "Ryder Russo"
            ],
            [
                'name' => "Connor Howard"
            ],
            [
                'name' => "Asher Brady"
            ],
            [
                'name' => "Randall Contreras"
            ],
            [
                'name' => "Brandon Ingram"
            ],
            [
                'name' => "August Vaughan"
            ],
            [
                'name' => "Beck Moran"
            ],
            [
                'name' => "Rudyard Bradshaw"
            ]
        ]);
        Teacher::truncate();

        $teachers->each(function ($teacher) {
            Teacher::create($teacher);
        });
    }
}
