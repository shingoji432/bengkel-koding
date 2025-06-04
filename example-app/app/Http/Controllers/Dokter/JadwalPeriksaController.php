<?php

namespace App\Http\Controllers\Dokter;

use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::user()->id)->get();
        return view('dokter.jadwal-periksa.index')->with(
            ja
        );
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

}
