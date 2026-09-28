<?php

namespace App\Http\Controllers\Student;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $totalLoanedBooks = auth()->user()->loans()->where('status', Status::LOANED)->count();
        $totalReturnedBooks = auth()->user()->loans()->where('status', Status::RETURNED)->count();
        $totalLateBooks = auth()->user()->loans()->where('status', Status::OVERDUE)->count();

        $activeLoans = auth()->user()->loans()->where('status', Status::LOANED)->latest()->get();

        $recentLoans = auth()->user()->loans()->latest()->take(5)->get();
        
        return view('pages.student.index', compact('totalLoanedBooks', 'totalReturnedBooks', 'totalLateBooks', 'activeLoans', 'recentLoans'));
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
