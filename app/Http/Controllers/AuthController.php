<?php

namespace App\Http\Controllers;

use App\Facades\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role_name === \App\Enums\Role::ADMIN) {
                return redirect('admin/dashboard');
            } else{
                return redirect('student/dashboard');
            }
        }
        return view('pages.auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_name === \App\Enums\Role::ADMIN) {
                return redirect()->intended('admin/dashboard');
            } else {
                return redirect()->intended('student/dashboard');
            }
        }

        return back()->with('swal', [
            'icon' => 'error',
            'title' => 'Gagal',
            'text' => 'Email tidak terdaftar atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => true]);
    }

    public function edit()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
