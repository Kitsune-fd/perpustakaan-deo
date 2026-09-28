<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobHistory>
 */
class JobHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => \App\Models\Teacher::factory(),
            'company_name' => $this->faker->company(),
            'position' => $this->faker->jobTitle(),
            'start_year' => $this->faker->year(),
            'end_year' => $this->faker->optional()->year(),
            'file_path' => null,
        ];
    }
}
