<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $password)
    {
        return view('pages.admin.password.edit', compact('password'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $password)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $password->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.profile.index')->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
