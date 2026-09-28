<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Book::factory(10)->create([
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'shelf_id' => \App\Models\Shelf::inRandomOrder()->first()->id,
            'cover_image' => 'https://dummyimage.com/200x300/000/fff&text=Book+Cover',
        ]);
    }
}
