<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = Teacher::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    if ($row->is_active) {
                        return '<span class="badge bg-success">Aktif</span>';
                    } else {
                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.report.show', $row->id).'" class="btn btn-sm btn-primary text-nowrap">
                        <i class="bi bi-file-earmark-text"></i> Lihat Data Guru
                    </a>
                    ';
                    $action .= '
                    <a href="'.route('admin.report.download', $row->id).'" target="_blank" class="btn btn-sm btn-secondary text-nowrap">
                        <i class="bi bi-download"></i> Unduh PDF
                    </a>
                    ';
                    return '
                    <div class="d-flex gap-2">
                        '.$action.'
                    </div>
                    ';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('pages.admin.report.index');
    }

    public function show(Teacher $teacher)
    {
        $teacher = $teacher->load('files', 'educationHistories', 'jobHistories', 'teachingHistories');
        return view('pages.admin.report.show', compact('teacher'));
    }

    public function download(Teacher $teacher)
    {
        $teacher = $teacher->load('files', 'educationHistories', 'jobHistories', 'teachingHistories');
        $pdf = Pdf::loadView('pages.admin.report.pdf', compact('teacher'));

        return $pdf->stream('document.pdf');
    }
}
