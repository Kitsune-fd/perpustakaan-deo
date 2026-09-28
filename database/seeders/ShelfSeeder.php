<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shelves = [
            ['name' => 'Rak A', 'location_description' => 'Lantai 1, Sisi Utara'],
            ['name' => 'Rak B', 'location_description' => 'Lantai 1, Sisi Selatan'],
            ['name' => 'Rak C', 'location_description' => 'Lantai 2, Sisi Barat'],
            ['name' => 'Rak D', 'location_description' => 'Lantai 2, Sisi Timur'],
            ['name' => 'Rak E', 'location_description' => 'Lantai 3, Sisi Utara'],
        ];

        foreach ($shelves as $shelf) {
            \App\Models\Shelf::create($shelf);
        }
    }
}
