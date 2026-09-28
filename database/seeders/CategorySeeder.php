<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bahasa Indonesia', 'description' => 'Kategori untuk buku-buku berbahasa Indonesia.'],
            ['name' => 'Bahasa Inggris', 'description' => 'Kategori untuk buku-buku berbahasa Inggris.'],
            ['name' => 'Sains', 'description' => 'Kategori untuk buku-buku tentang sains dan teknologi.'],
            ['name' => 'Sosial', 'description' => 'Kategori untuk buku-buku tentang ilmu sosial dan humaniora.'],
            ['name' => 'Agama', 'description' => 'Kategori untuk buku-buku tentang agama dan spiritualitas.'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
