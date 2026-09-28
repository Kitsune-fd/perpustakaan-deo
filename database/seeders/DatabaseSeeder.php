<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\Role;
use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@smkn2-medan.go.id',
            'password' => Hash::make('123'),
            'role_name' => Role::ADMIN,
        ]);

        $student = \App\Models\User::factory()->create([
            'name' => 'Student',
            'email' => 'student@smkn2-medan.go.id',
            'password' => Hash::make('123'),
            'role_name' => Role::STUDENT,
        ]);

        $this->call([
            CategorySeeder::class,
            ShelfSeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
        ]);

        \App\Models\Loan::factory()->create([
            'user_id' => $student->id,
            'status' => 'loaned',
            'due_date' => now()->addDays(2),
            'loaned_date' => now()->subDays(10),
        ]);
    }
}
