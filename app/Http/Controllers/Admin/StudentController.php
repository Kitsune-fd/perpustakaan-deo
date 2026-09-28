<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->siswa()->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.student.edit', $row->id).'" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    ';
                    $action .= '
                    <a href="'.route('admin.student.change-password', $row->id).'" class="btn btn-sm btn-info">
                        <i class="bi bi-key"></i>
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.student.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('pages.admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_name' => Role::STUDENT,
        ]);
        
        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil ditambahkan');
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
    public function edit(User $student)
    {
        return view('pages.admin.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function changePassword(User $student)
    {
        return view('pages.admin.student.change-password', compact('student'));
    }

    public function updatePassword(Request $request, User $student)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $student->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Password siswa berhasil diubah');
    }
}
