<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\medikaPasien;
use App\Models\medikaDokter;
use App\Models\medikapoliklinik;
use Illuminate\Http\Request; 

class RekamMedisController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'poliklinik', 'userlogin'])->get();
        return view('admin.Rekammedis.index', compact('rekamMedis'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $pasien = medikaPasien::all();  // Fetch all pasien data
        $dokter = medikaDokter::all();  // Fetch all dokter data
        $poliklinik = medikapoliklinik::all();  // Fetch all poliklinik data
    
        return view('admin.Rekammedis.create', compact('pasien', 'dokter', 'poliklinik'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pasienId' => 'required|exists:pasien,idPasien',
            'dokterNip' => 'required|exists:dokter,nip',
            'poliklinikId' => 'required|exists:poliklinik,idPoliklinik',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'terapi' => 'required|string',
            'tglPeriksa' => 'required|date',
        ]);

        RekamMedis::create(array_merge($validatedData, ['userId' => auth()->id()]));

        return redirect()->route('rekammedis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    // Display the specified resource
    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'poliklinik', 'userlogin'])->findOrFail($id);
        return view('rekammedis.show', compact('rekamMedis'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
{
    // Fetch the Rekam Medis record
    $rekamMedis = RekamMedis::find($id); // Adjust the model name as necessary

    // Check if the record exists
    if (!$rekamMedis) {
        return redirect()->route('rekammedis.index')->withErrors('Record not found.');
    }

    // Fetch related models for dropdowns
    $pasien = medikaPasien::all(); // Fetch all Pasien
    $dokter = medikaDokter::all(); // Fetch all Dokter
    $poliklinik = medikaPoliklinik::all(); // Fetch all Poliklinik

    return view('admin.Rekammedis.edit', compact('rekamMedis', 'pasien', 'dokter', 'poliklinik'));
}


    // Update the specified resource in storage
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'pasienId' => 'required|exists:pasien,idPasien',
        'dokterNip' => 'required|exists:dokter,nip',
        'poliklinikId' => 'required|exists:poliklinik,idPoliklinik',
        'keluhan' => 'required|string',
        'diagnosa' => 'required|string',
        'terapi' => 'required|string',
        'tglPeriksa' => 'required|date'
    ]);

    $rekamMedis = RekamMedis::findOrFail($id);
    // Update userId with the currently authenticated user's ID
    $rekamMedis->update(array_merge($validatedData, ['userId' => auth()->id()]));

    return redirect()->route('rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
}


    // Remove the specified resource from storage
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->delete();

        return redirect()->route('rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
