<?php

namespace App\Http\Controllers\Student;

use App\DTO\LoanDTO;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\LoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LoanController extends Controller
{   
    public function __construct(
        public LoanService $loanService
    )
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Loan::query()
            ->where('user_id', auth()->id())
            ->isActive()
            ->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="' . route('student.loan.show', $row->id) . '" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>';
                    $action .= '<button type="button" data-id="' . $row->id . '" id="cancel" class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i></button>
                    ';
                    return '
                        <div class="d-flex gap-2">
                            '.$action.'
                        </div>
                    ';
                })
                ->addColumn('user', function($row){
                    return $row->user->name ?? '-';
                })
                ->addColumn('title', function($row){
                    return $row->book->title ?? '-';
                })
                ->editColumn('status', function($row){
                    return '<span class="badge ' . $row->status->badgeClass() . '">' . ucfirst($row->status->label()) . '</span>';
                })
                ->rawColumns(['action', 'status'])
                ->filterColumn('user', function($query, $keyword) {
                    $query->whereHas('user', function($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })
                ->make(true);
        }
        return view('pages.student.loan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view('pages.student.loan.create', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {   
        $this->loanService->create(
            new LoanDTO(
                student: auth()->user(),
                book: Book::findOrFail($request->book_id),
                loanDate: \Carbon\Carbon::parse($request->loaned_date),
                dueDate: \Carbon\Carbon::parse($request->due_date),
            )
        );

        return redirect()->route('student.book.index')->with('success', 'Buku berhasil dipinjam! silahkan cek email untuk informasi lebih lanjut.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {   
        if($loan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('pages.student.loan.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(Loan $loan)
    {
        $loan->update([
            'status' => Status::CANCELED
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dibatalkan'
        ]);
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
