<?php
namespace App\Services;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class PenggunaService
{
    public function getUserGuru()
    {
        $model = Guru::where('user_id', Auth::id())->first();
        return $model;
    }

    public function getUserSiswa()
    {
        $model = Siswa::where('user_id', Auth::id())->first();
        return $model;
    }
}
