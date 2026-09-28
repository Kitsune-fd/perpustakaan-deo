<?php

namespace Database\Factories;

use App\Enums\Degree;
use App\Enums\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EducationHistoryFactory extends Factory
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
            'institution_name' => $this->faker->company,
            'degree_obtained' => $this->faker->randomElement(Degree::getValues()),
            'education' => $this->faker->randomElement(Education::getValues()),
            'graduation_year' => $this->faker->year,
            'file_path' => null,
        ];
    }
}
