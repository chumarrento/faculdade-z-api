<?php

namespace Database\Factories;

use App\Models\Discipline;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'weekday' => $this->faker->dayOfWeek,
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'discipline_id' => Discipline::factory()
        ];
    }
}
