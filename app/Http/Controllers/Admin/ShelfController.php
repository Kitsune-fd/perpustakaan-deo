<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shelf::orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '
                    <a href="'.route('admin.shelf.edit', $row->id).'" class="btn btn-sm btn-warning">
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.shelf.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('pages.admin.shelf.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:255|unique:shelves,name',
            'location_description' => 'nullable|string|max:1000',
        ]);

        Shelf::create([
            'name' => $request->name,
            'location_description' => $request->location_description,
        ]);
        
        return redirect()->route('admin.shelf.index')->with('success', 'Rak berhasil ditambahkan');
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
    public function edit(Shelf $shelf)
    {
        return view('pages.admin.shelf.edit', compact('shelf'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shelf $shelf)
    {   
        $request->validate([
            'name' => 'required|string|max:255|unique:shelves,name,' . $shelf->id,
            'location_description' => 'nullable|string|max:1000',
        ]);

        $shelf->update([
            'name' => $request->name,
            'location_description' => $request->location_description,
        ]);

        return redirect()->route('admin.shelf.index')->with('success', 'Rak berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shelf $shelf)
    {
        $shelf->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
