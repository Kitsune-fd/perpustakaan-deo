<?php

namespace App\DTO;

use App\Enums\Education;
use App\Enums\Subject;
use App\Models\Category;
use App\Models\Shelf;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class BookDTO
{
    public function __construct(
        public string $title,
        public string $author,
        public string $publisher,
        public Category $category,
        public Shelf $shelf,
        public int $stockTotal,
        public int $year,
        public ?string $description = null,
    ) {
        // 
    }
}
