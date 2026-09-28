<?php

namespace Database\Factories;

use App\Enums\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeachingHistory>
 */
class TeachingHistoryFactory extends Factory
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
            'subject' => $this->faker->randomElement(Subject::getValues()),
            'grade_level' => $this->faker->word(),
            'start_year' => $this->faker->year(),
            'end_year' => $this->faker->optional()->year(),
        ];
    }
}
