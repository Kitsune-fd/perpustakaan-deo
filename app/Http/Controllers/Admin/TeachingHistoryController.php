<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobHistoryRequest;
use App\Http\Requests\TeachingHistoryRequest;
use App\Models\EducationHistory;
use App\Models\JobHistory;
use App\Models\Teacher;
use App\Models\TeachingHistory;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class TeachingHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Teacher::with('teachingHistories')->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('history', function($row){
                    $history_count = $row->teachingHistories()->count();
                    $history = view('pages.admin.history.teaching._history', [
                        'id' => $row->id,
                        'history_count' => $history_count
                    ])->render();
                    return $history;
                })
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.teaching-history.show', $row->id).'" class="btn btn-sm btn-primary text-nowrap">
                        <i class="fa fa-book"></i> Lihat Riwayat Mengajar
                    </a>
                    ';
                    return $action;
                })
                ->rawColumns(['action', 'history'])
                ->make(true);
        }
        return view('pages.admin.history.teaching.index');
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
    public function store(TeachingHistoryRequest $request)
    {   
        try {
            $teachingHistory = new TeachingHistory();
            $teachingHistory->teacher_id = $request->teacher_id;
            $teachingHistory->subject = $request->subject;
            $teachingHistory->grade_level = $request->grade_level;
            $teachingHistory->start_year = $request->start_year;
            $teachingHistory->end_year = $request->end_year;
            $teachingHistory->save();
    
            return redirect()->back()->with('success', 'Riwayat mengajar berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan pada sistem: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('pages.admin.history.teaching.show', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeachingHistoryRequest $request, TeachingHistory $teaching_history)
    {
        try {
            $teaching_history->subject = $request->subject;
            $teaching_history->grade_level = $request->grade_level;
            $teaching_history->start_year = $request->start_year;
            $teaching_history->end_year = $request->end_year;
            $teaching_history->save();
    
            return redirect()->back()->with('success', 'Riwayat mengajar berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan pada sistem: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeachingHistory $teaching_history)
    {
        try {
            $teaching_history->delete();

            return redirect()->back()->with('success', 'Riwayat mengajar berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan pada sistem: ' . $e->getMessage()]);
        }
    }
}
