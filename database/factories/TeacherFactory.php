<?php

namespace Database\Factories;

use App\Enums\Education;
use App\Enums\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'nip' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name(),
            'birthdate' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'subject' => $this->faker->randomElement(Subject::getValues()),
            'last_education' => $this->faker->randomElement(Education::getValues()),
            'is_active' => $this->faker->boolean(),
            'address' => $this->faker->address(),
        ];
    }
}
