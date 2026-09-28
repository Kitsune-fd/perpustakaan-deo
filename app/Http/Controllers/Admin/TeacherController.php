<?php

namespace App\Http\Controllers\Admin;

use App\DTO\TeacherDTO;
use App\Enums\DocumentType;
use App\Enums\Education;
use App\Enums\Subject;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobHistoryRequest;
use App\Http\Requests\TeacherRequest;
use App\Models\EducationHistory;
use App\Models\File;
use App\Models\JobHistory;
use App\Models\Teacher;
use App\Services\TeacherService;
use Carbon\Carbon;
use Dom\Document;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{   
    public function __construct(
        private TeacherService $teacherService
    )
    {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Teacher::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $isChecked = $row->is_active ? 'checked' : '';
                    $status = '
                        <div class="form-check form-switch">
                            <input class="form-check-input status-change" type="checkbox" data-status="'.$row->status_label_short.'" data-id="'.$row->id.'" '.$isChecked.'>
                        <label class="form-check-label" for="is_status'.$row->id.'">'. $row->status_label_short .'</label>
                        </div>
                    ';

                    return $status;
                })
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.teacher.show', $row->id).'" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    ';
                    $action .= '
                    <a href="'.route('admin.teacher.edit', $row->id).'" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    ';
                    $action .= '<button type="button" data-id="' . $row->id . '" id="delete" class="btn btn-danger btn-sm" data-id="' . $row->id . '"><i class="bi bi-trash"></i></button>
                    ';
                    $action .= '
                    <a href="'.route('admin.teacher.document.upload', $row->id).'" class="btn btn-sm btn-success">
                        <i class="bi bi-upload"></i>
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
        return view('pages.admin.teacher.index');
    }

    public function create()
    {
        return view('pages.admin.teacher.create');
    }

    public function store(TeacherRequest $request)
    {   
        $this->teacherService->store(new TeacherDTO(
            name: $request->name,
            nip: $request->nip,
            subject: Subject::tryFrom($request->subject),
            lastEducation: Education::tryFrom($request->last_education),
            birthdate: Carbon::parse($request->birthdate),
            gender: $request->gender,
            address: $request->address,
            isActive: $request->is_active,
        ));

        return redirect()->route('admin.teacher.index')->with('success', 'Berhasil menambahkan data guru baru. Silahkan unggah dokumen pendukung pada halaman detail guru');
    }

    public function show(Teacher $teacher)
    {
        return view('pages.admin.teacher.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('pages.admin.teacher.edit', compact('teacher'));
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $this->teacherService->update($teacher, new TeacherDTO(
            name: $request->name,
            nip: $request->nip,
            subject: Subject::tryFrom($request->subject),
            lastEducation: Education::tryFrom($request->last_education),
            birthdate: Carbon::parse($request->birthdate),
            gender: $request->gender,
            address: $request->address,
            isActive: $request->is_active,
        ));

        return redirect()->route('admin.teacher.index')->with('success', 'Berhasil memperbarui data guru.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json(['success' => 'Berhasil menghapus data guru.']);
    }

    public function status(Teacher $teacher)
    {
        try {
            $teacher->is_active = !$teacher->is_active;
            $teacher->save();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function formUpload(Teacher $teacher)
    {
        return view('pages.admin.teacher.upload', compact('teacher'));
    }

    public function upload(Request $request, Teacher $teacher)
    {   
        $validated = $request->validate([
            'documents' => ['required', 'array', 'min:1'],

            'documents.*.file' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],

            'documents.*.description' => ['nullable', 'string', 'max:255'],
            'documents.*.type' => ['nullable', Rule::in(DocumentType::getValues())],
        ]);


        $documents = [];

        foreach ($validated['documents'] as $index => $data) {
            $documents[] = [
                'file' => $request->file("documents.$index.file"), // ✅ AMBIL FILE DARI file()
                'description' => $data['description'] ?? null,
                'type' => $data['type'] ?? null,
            ];
        }

        $this->teacherService->storeDocument($teacher, $documents);

        return redirect()->route('admin.teacher.show', $teacher->id)->with('success', 'Berhasil mengunggah dokumen.');
    }

    public function destroyDocument(Teacher $teacher, File $file)
    {   
        try {
            if($file->teacher_id !== $teacher->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan untuk guru ini.'
                ], 404);
            }
            if (Storage::disk('public')->exists($file->filepath)) {
                Storage::disk('public')->delete($file->filepath);
            }

            $file->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
