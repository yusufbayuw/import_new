<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function rekapUnit()
    {
        $pegawai = \App\Models\Pegawai::withCount('mutasi')->get();

        // Rekap berdasarkan unit
        $rekap = $pegawai->groupBy('unit')->map(function ($group) {
            return $group->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nip' => $item->nip,
                    'nama' => $item->nama,
                    'unit' => $item->unit,
                    'mutasi_count' => $item->mutasi_count,
                    'is_tetap' => $item->is_tetap,
                ];
            });
        });

        return view('rekap-unit', compact('rekap'));
    }
}
