<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\medikaPasien;
use App\Models\medikaDokter;
use App\Models\medikaPoliklinik;
use Illuminate\Http\Request; 

class RekamMedisController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
    // Get the search query from the request (if provided)
    $search = $request->input('search');

    // Query RekamMedis with relationships and search functionality
    $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'poliklinik', 'userlogin'])
        ->when($search, function ($query, $search) {
            return $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('namaPasien', 'like', '%' . $search . '%');
            })
            ->orWhereHas('dokter', function ($q) use ($search) {
                $q->where('namaDokter', 'like', '%' . $search . '%');
            })
            ->orWhere('keluhan', 'like', '%' . $search . '%')
            ->orWhere('diagnosa', 'like', '%' . $search . '%')
            ->orWhere('terapi', 'like', '%' . $search . '%');
        })
        ->paginate(10); // Paginate results, 10 per page (adjust as needed)

    // Return the view with the paginated RekamMedis data and search term
    return view('admin.Rekammedis.index', compact('rekamMedis', 'search'));
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
