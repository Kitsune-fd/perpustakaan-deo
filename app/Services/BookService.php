<?php
namespace App\Services;

use App\DTO\BookDTO;
use App\Models\Book;
use App\Models\Teacher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookService
{
    public function create(BookDTO $bookData): Book
    {
        $book = Book::create([
            'title' => $bookData->title,
            'author' => $bookData->author,
            'publisher' => $bookData->publisher,
            'year' => $bookData->year,
            'category_id' => $bookData->category?->id,
            'shelf_id' => $bookData->shelf?->id,
            'stock_total' => $bookData->stockTotal,
            'cover_image' => null,
            'description' => $bookData->description,
        ]);

        return $book;
    }

    public function edit(BookDTO $bookData, Book $book): Book
    {
        $book->update([
            'title' => $bookData->title,
            'author' => $bookData->author,
            'publisher' => $bookData->publisher,
            'year' => $bookData->year,
            'category_id' => $bookData->category?->id,
            'shelf_id' => $bookData->shelf?->id,
            'stock_total' => $bookData->stockTotal,
            'description' => $bookData->description,
        ]);

        return $book->fresh();
    }

    public function uploadCoverImage(UploadedFile $coverImage, Book $book): Book
    {   

        $filename = Str::slug($book->title) . '-' . time() . '.' . $coverImage->getClientOriginalExtension();
        $path = $coverImage->storeAs('public/covers', $filename);
        
        $book->update(['cover_image' => Storage::url($path)]);
        
        return $book->fresh();
    }

    public function deleteCoverImage(Book $book): Book
    {
        if ($book->cover_image) {
            $path = str_replace('/storage/', 'public/', $book->cover_image);
            Storage::delete($path);
            $book->update(['cover_image' => null]);
        }
        
        return $book->fresh();
    }
}