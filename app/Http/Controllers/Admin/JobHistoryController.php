<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobHistoryRequest;
use App\Models\EducationHistory;
use App\Models\JobHistory;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class JobHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Teacher::with('jobHistories')->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('history', function($row){
                    $history_count = $row->jobHistories()->count();
                    $history = view('pages.admin.history.job._history', [
                        'id' => $row->id,
                        'history_count' => $history_count
                    ])->render();
                    return $history;
                })
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.job-history.show', $row->id).'" class="btn btn-sm btn-primary text-nowrap">
                        <i class="fa fa-book"></i> Lihat Riwayat Pekerjaan
                    </a>
                    ';
                    return $action;
                })
                ->rawColumns(['action', 'history'])
                ->make(true);
        }
        return view('pages.admin.history.job.index');
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
    public function store(JobHistoryRequest $request)
    {   
        try {
            $jobHistory = new JobHistory();
            $jobHistory->teacher_id = $request->teacher_id;
            $jobHistory->company_name = $request->company_name;
            $jobHistory->position = $request->position;
            $jobHistory->start_year = $request->start_year;
            $jobHistory->end_year = $request->end_year;

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('teacher_documents', $fileName, 'public');
                $jobHistory->file_path = $filePath;
            }
    
            $jobHistory->save();
    
            return redirect()->back()->with('success', 'Riwayat pekerjaan berhasil ditambahkan.');
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
        return view('pages.admin.history.job.show', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobHistoryRequest $request, JobHistory $job_history)
    {
        try {
            $job_history->company_name = $request->company_name;
            $job_history->position = $request->position;
            $job_history->start_year = $request->start_year;
            $job_history->end_year = $request->end_year;
    
            if ($request->hasFile('file_path')) {
                // Hapus file lama jika ada
                if ($job_history->file_path && Storage::disk('public')->exists($job_history->file_path)) {
                    Storage::disk('public')->delete($job_history->file_path);
                }
    
                $file = $request->file('file_path');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('teacher_documents', $fileName, 'public');
                $job_history->file_path = $filePath;
            }
    
            $job_history->save();
    
            return redirect()->back()->with('success', 'Riwayat pendidikan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan pada sistem: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobHistory $job_history)
    {
        try {
            // Hapus file terkait jika ada
            if ($job_history->file_path && Storage::disk('public')->exists($job_history->file_path)) {
                Storage::disk('public')->delete($job_history->file_path);
            }

            $job_history->delete();

            return redirect()->back()->with('success', 'Riwayat pekerjaan berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan pada sistem: ' . $e->getMessage()]);
        }
    }
}
