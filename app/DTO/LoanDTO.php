<?php

namespace App\DTO;

use App\Enums\Education;
use App\Enums\Subject;
use App\Models\Book;
use App\Models\Category;
use App\Models\Shelf;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class LoanDTO
{
    public function __construct(
        public User $student,
        public Book $book,
        public Carbon $loanDate,
        public Carbon $dueDate,
    ) {
        // 
    }
}
