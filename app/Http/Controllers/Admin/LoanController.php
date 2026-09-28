<?php

namespace App\Http\Controllers\Admin;

use App\DTO\LoanDTO;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Services\LoanService;
use Carbon\Carbon;
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
            $data = Loan::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $url = $row->status === Status::LOANED 
                        ? route('admin.loan.return.create', $row->id)
                        : '#';
    
                    $disabled = $row->status !== Status::LOANED ? 'disabled pointer-events-none opacity-50' : '';
                    $action = '<button type="button" data-id="' . $row->id . '" id="delete" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>';

                    $action .= '<a href="' . $url . '" 
                                    class="btn btn-primary btn-sm ' . $disabled . '">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Pengembalian
                                </a>';

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
        return view('pages.admin.loan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('pages.admin.loan.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createReturn(Loan $loan)
    {   
        return view('pages.admin.loan.return.create', compact('loan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {   
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        return view('pages.admin.loan.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {   
        //
    }

    public function return(Request $request, Loan $loan)
    {   
        $request->validate([
            'returned_date' => 'required|date',
            'fine_amount' => 'nullable|numeric',
        ]);

        $isDue = Carbon::parse($request->returned_date)->gt($loan->due_date);

        $this->loanService->return($loan, $isDue);

        return redirect()->route('admin.loan.index')->with('success', 'Buku berhasil dikembalikan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        if($loan->status !== Status::RESERVED) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak dapat dihapus karena status buku bukan "Dipesan"'
            ], 400);
        }

        $loan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
