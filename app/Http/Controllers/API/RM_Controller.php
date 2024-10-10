<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\medikaPasien;
use App\Models\medikaDokter;
use App\Models\medikaPoliklinik; // Fix the case here
use Illuminate\Http\Request;

class RM_Controller extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'poliklinik', 'userlogin'])->get();
        return response()->json($rekamMedis); // Return data as JSON
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

        // Create a new RekamMedis record
        $rekamMedis = RekamMedis::create(array_merge($validatedData, ['userId' => auth()->id()]));

        return response()->json([
            'message' => 'Rekam medis berhasil ditambahkan.',
            'rekamMedis' => $rekamMedis
        ], 201); // Return status 201: Created
    }

    // Display the specified resource
    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'poliklinik', 'userlogin'])->findOrFail($id);
        return response()->json($rekamMedis); // Return data as JSON
    }

    // Show the form for editing the specified resource
    // For an API, you typically don't need an edit method that returns a view.
    // Editing is usually done via GET + PATCH/PUT requests.

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
        $rekamMedis->update(array_merge($validatedData, ['userId' => auth()->id()]));

        return response()->json([
            'message' => 'Rekam medis berhasil diperbarui.',
            'rekamMedis' => $rekamMedis
        ]);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->delete();

        return response()->json([
            'message' => 'Rekam medis berhasil dihapus.'
        ]);
    }
}
