<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttendanceModel>
 */
class AttendanceModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => 1,
            'date' => date('Y-m-d'),
            'time_in_am' => $this->faker->time(),
            'time_in_pm' => $this->faker->time(),
        ];
    }
}
