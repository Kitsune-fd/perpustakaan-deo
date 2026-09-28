<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Loan::query()
            ->where('user_id', auth()->id())
            ->isHistory()
            ->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="' . route('student.history.show', $row->id) . '" class="btn btn-info btn-sm"><i class="bi bi-eye me-1"></i>Detail</a>';
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
        return view('pages.student.history.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $history)
    {
        return view('pages.student.history.show', [
            'loan' => $history
        ]);
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
    public function destroy(string $id)
    {
        //
    }
}
