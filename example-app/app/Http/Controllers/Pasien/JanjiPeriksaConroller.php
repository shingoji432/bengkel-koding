<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JanjiPeriksa;

class JanjiPeriksaConroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $no_rm = Auth::user()->no_rm;
        $dokters = User::with(['jadwalPeriksa' => function ($query){
            $query->where('status', true);
        }])->where('role', 'dokter');

        return view('pasien.janji-periksa.index')->with(['dokters'=>$dokters, 'no_rm'=>$no_rm]);
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
        $request->validate([
            'id_dokter' => 'required|exists:users,id',
            'keluhan' => 'required',
        ]);

        //$jadwalPeriksa = JadwalPeriksa::where('id_dokter', $request->id_dokter)
        //    ->
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
