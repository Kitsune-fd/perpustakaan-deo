<?php

namespace App\Http\Controllers;

use App\Facades\Pengguna;
use Illuminate\Http\Request;

class AjaxLoadController extends Controller
{
    // public function getSiswaKelas(Request $request)
    // {
    //     $searchTerm = $request->input('q');
    //     $data = \App\Models\Siswa::with('user')->where('nama', 'LIKE', '%' . $searchTerm . '%')
    //         ->get(['id', 'nama', 'user_id'])
    //         ->map(function ($item) {
    //             return [
    //                 'id' => $item->id,
    //                 'text' => $item->nama . ' - ' . $item->user->username
    //             ];
    //         })
    //         ->toArray();

    //     return response()->json($data);  // Kembalikan sebagai JSON
    // }

    public function getSiswa(Request $request)
    {
        $searchTerm = $request->input('q');
        $data = \App\Models\Siswa::where('nama', 'LIKE', '%' . $searchTerm . '%')
            ->get(['id', 'nama'])
            ->toArray();

        return response()->json($data);  // Kembalikan sebagai JSON
    }

    public function getGuru(Request $request)
    {
        $searchTerm = $request->input('q');
        $data = \App\Models\Teacher::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->get(['id', 'name'])
            ->toArray();

        return response()->json($data);  // Kembalikan sebagai JSON
    }

    // public function getKelas(Request $request)
    // {
    //     $searchTerm = $request->input('q');
    //     $data = \App\Models\RefKelas::where('nama_kelas', 'LIKE', '%' . $searchTerm . '%')
    //         ->get(['id', 'nama_kelas'])
    //         ->toArray();

    //     return response()->json($data);  // Kembalikan sebagai JSON
    // }

    // public function getMapel(Request $request)
    // {
    //     $searchTerm = $request->input('q');
    //     $data = \App\Models\RefMapel::where('nama_mapel', 'LIKE', '%' . $searchTerm . '%')
    //         ->get(['id', 'nama_mapel'])
    //         ->toArray();

    //     return response()->json($data);  // Kembalikan sebagai JSON
    // }

    public function getGuruMapel(Request $request)
    {
        $searchTerm = $request->input('q');
        $data = \App\Models\Guru::with('mapel')->where('nama', 'LIKE', '%' . $searchTerm . '%')
            ->get(['id', 'nama', 'mapel_id'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama . ' - ' . $item->mapel->nama_mapel
                ];
            })
            ->toArray();

        return response()->json($data);  // Kembalikan sebagai JSON
    }

    public function getJadwalPembelajaran(Request $request)
    {
        $guru_id = Pengguna::getUserGuru()->id ?? null;
        $jadwalAvailId = \App\Models\Pembelajaran::where('guru_id', $guru_id)->pluck('jadwal_id')->toArray();
        $jadwalAvailId2 = \App\Models\Tugas::where('guru_id', $guru_id)->pluck('jadwal_id')->toArray();
        $searchTerm = $request->input('q');
        $data = \App\Models\Jadwal::where('guru_id', $guru_id)
            ->whereNotIn('id', $jadwalAvailId)
            ->whereNotIn('id', $jadwalAvailId2)
            ->where(function ($query) {
                $query->where('tanggal', '>=', now()->format('Y-m-d'));
            })
            ->where('nama_jadwal', 'LIKE', '%' . $searchTerm . '%')
            ->get(['id', 'nama_jadwal', 'tanggal', 'jam_mulai', 'jam_selesai'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama_jadwal . ' - ' . $item->tanggal . ' (' . \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') . ')'
                ];
            })
            ->toArray();

        return response()->json($data);  // Kembalikan sebagai JSON
    }
}
