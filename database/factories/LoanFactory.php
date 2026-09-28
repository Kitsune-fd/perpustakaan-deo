<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'book_id' => \App\Models\Book::factory(),
            'loaned_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'returned_date' => null,
            'status' => $this->faker->randomElement(Status::cases())->value,
            'code' => $this->faker->unique()->numerify('LN-#####'),
            'last_reminder_sent_at' => null,
            'fine_amount' => 0.00,
        ];
    }
}
