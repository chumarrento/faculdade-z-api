<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Support;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Support::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'message' => $this->faker->text,
            'student_id' => Student::factory()
        ];
    }
}
