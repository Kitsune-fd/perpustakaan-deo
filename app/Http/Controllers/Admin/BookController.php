<?php

namespace App\Http\Controllers\Admin;

use App\DTO\BookDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Shelf;
use App\Services\BookService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{   
    public function __construct(
        public BookService $bookService
    )
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('cover_image', function($row){
                    $urlImage = $row->cover_image ?? asset('images/no-image.png');
                    return '<img src="'.$urlImage.'" class="img-fluid rounded" style="width: 50px; height: 75px; object-fit: cover;">';
                })
                ->addColumn('category', function($row){
                    return $row->category->name ?? '-';
                })
                ->addColumn('shelf', function($row){
                    return $row->shelf->name ?? '-';
                })
                ->addColumn('stock', function($row){
                    return $row->stock_available ?? 0;
                })
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.book.show', $row->id).'" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i>
                    </a>
                    ';
                    $action .= '
                    <a href="'.route('admin.book.edit', $row->id).'" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    ';
                    $action .= '<button type="button" data-id="' . $row->id . '" id="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                    ';
                    return '
                        <div class="d-flex gap-2">
                            '.$action.'
                        </div>
                    ';
                })
                ->rawColumns(['action', 'cover_image'])
                ->filterColumn('category', function($query, $keyword) {
                    $query->whereHas('category', function($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })
                ->filterColumn('shelf', function($query, $keyword) {
                    $query->whereHas('shelf', function($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })
                ->make(true);
        }
        return view('pages.admin.book.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = \App\Models\Category::lazy();
        $shelves = \App\Models\Shelf::lazy();
        return view('pages.admin.book.create', compact('categories', 'shelves'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {   
        $bookData = new BookDTO(
            title: $request->title,
            author: $request->author,
            publisher: $request->publisher,
            year: $request->year ?? now()->year,
            category: Category::find($request->category_id),
            shelf: Shelf::find($request->shelf_id),
            stockTotal: $request->stock_total,
        );

        $book = $this->bookService->create($bookData);

        if ($request->hasFile('cover_image')) {
            $this->bookService->uploadCoverImage($request->file('cover_image'), $book);
        }
        
        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('pages.admin.book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = \App\Models\Category::lazy();
        $shelves = \App\Models\Shelf::lazy();
        return view('pages.admin.book.edit', compact('book', 'categories', 'shelves'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $bookData = new BookDTO(
            title: $request->title,
            author: $request->author,
            publisher: $request->publisher,
            year: $request->year ?? now()->year,
            category: Category::find($request->category_id),
            shelf: Shelf::find($request->shelf_id),
            stockTotal: $request->stock_total,
        );

        $this->bookService->edit($bookData, $book);

        if ($request->hasFile('cover_image')) {
            $this->bookService->deleteCoverImage($book);
            $this->bookService->uploadCoverImage($request->file('cover_image'), $book);
        }

        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->bookService->deleteCoverImage($book);
        $book->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
