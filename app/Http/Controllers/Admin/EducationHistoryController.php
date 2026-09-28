<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationHistoryRequest;
use App\Models\EducationHistory;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class EducationHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Teacher::with('educationHistories')->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('history', function($row){
                    $education_history_count = $row->educationHistories()->count();
                    $history = view('pages.admin.history.education._history', [
                        'id' => $row->id,
                        'education_history_count' => $education_history_count
                    ])->render();
                    return $history;
                })
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.education-history.show', $row->id).'" class="btn btn-sm btn-primary btn-history text-nowrap">
                        <i class="fa fa-book"></i> Lihat Riwayat Pendidikan
                    </a>
                    ';
                    return $action;
                })
                ->rawColumns(['action', 'history'])
                ->make(true);
        }
        return view('pages.admin.history.education.index');
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
    public function store(EducationHistoryRequest $request)
    {   
        try {
            $educationHistory = new EducationHistory();
            $educationHistory->teacher_id = $request->teacher_id;
            $educationHistory->education = $request->education;
            $educationHistory->institution_name = $request->institution_name;
            $educationHistory->degree_obtained = $request->degree_obtained;
            $educationHistory->graduation_year = $request->graduation_year;
    
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('teacher_documents', $fileName, 'public');
                $educationHistory->file_path = $filePath;
            }
    
            $educationHistory->save();
    
            return redirect()->back()->with('success', 'Riwayat pendidikan berhasil ditambahkan.');
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
        return view('pages.admin.history.education.show', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EducationHistoryRequest $request, EducationHistory $education_history)
    {
        try {
            $education_history->education = $request->education;
            $education_history->institution_name = $request->institution_name;
            $education_history->degree_obtained = $request->degree_obtained;
            $education_history->graduation_year = $request->graduation_year;
    
            if ($request->hasFile('file_path')) {
                // Hapus file lama jika ada
                if ($education_history->file_path && Storage::disk('public')->exists($education_history->file_path)) {
                    Storage::disk('public')->delete($education_history->file_path);
                }
    
                $file = $request->file('file_path');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('teacher_documents', $fileName, 'public');
                $education_history->file_path = $filePath;
            }
    
            $education_history->save();
    
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
    public function destroy(EducationHistory $education_history)
    {
        try {
            // Hapus file terkait jika ada
            if ($education_history->file_path && Storage::disk('public')->exists($education_history->file_path)) {
                Storage::disk('public')->delete($education_history->file_path);
            }

            $education_history->delete();

            return redirect()->back()->with('success', 'Riwayat pendidikan berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan pada sistem: ' . $e->getMessage()]);
        }
    }
}
