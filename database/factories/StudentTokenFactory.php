<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\StudentToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => $this->faker->uuid,
            'student_id' => Student::factory()
        ];
    }
}
