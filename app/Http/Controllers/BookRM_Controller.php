<?php

namespace App\Http\Controllers;

use App\Models\Book_RM;
use App\Models\medikaDokter;
use App\Models\medikaPoliklinik;
use App\Models\ApiUser; // Use the ApiUser model
use Illuminate\Http\Request;

class BookRM_Controller extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
{
    $search = $request->input('search');

    $rekamMedis = Book_RM::with(['dokter', 'poliklinik', 'userlogin'])
        ->when($search, function ($query, $search) {
            return $query->whereHas('dokter', function ($q) use ($search) {
                $q->where('namaDokter', 'like', '%' . $search . '%');
            })
            ->orWhere('idRekamMedis', 'like', '%' . $search . '%')
            ->orWhere('keluhan', 'like', '%' . $search . '%')
            ->orWhere('diagnosa', 'like', '%' . $search . '%')
            ->orWhere('terapi', 'like', '%' . $search . '%')
            ->orWhereHas('userlogin', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%'); // Search by name in user_app
            });
        })
        ->paginate(10);

    return view('admin.Book_RM.index', compact('rekamMedis', 'search'));
}

    // Show the form for creating a new resource
    public function create()
    {
        $pasien = ApiUser::all();
        $dokter = medikaDokter::all();  // Fetch all dokter data
        $poliklinik = medikaPoliklinik::all();  // Fetch all poliklinik data

        return view('admin.Book_RM.create', compact('dokter', 'poliklinik', 'pasien'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idRekamMedis' => 'required|string|size:15|unique:book_rm,idRekamMedis',
            'dokterNip' => 'required|exists:dokter,nip',
            'pasienId' => 'required|exists:user_app,id', // Validate pasienId
            'poliklinikId' => 'required|exists:poliklinik,idPoliklinik',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'terapi' => 'required|string',
            'tglPeriksa' => 'required|date',
        ]);

        Book_RM::create(array_merge($validatedData, ['userId' => auth()->id()]));

        return redirect()->route('book_rm.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    // Display the specified resource
    public function show($id)
    {
        $rekamMedis = Book_RM::with(['dokter', 'poliklinik', 'userlogin'])->findOrFail($id);
        return view('admin.Rekammedis.show', compact('rekamMedis'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $rekamMedis = Book_RM::find($id);

        if (!$rekamMedis) {
            return redirect()->route('book_rm.index')->withErrors('Record not found.');
        }

        $pasien = ApiUser::all();
        $dokter = medikaDokter::all();
        $poliklinik = medikaPoliklinik::all();

        return view('admin.Book_RM.edit', compact('rekamMedis', 'dokter', 'poliklinik','pasien'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dokterNip' => 'required|exists:dokter,nip',
            'poliklinikId' => 'required|exists:poliklinik,idPoliklinik',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'terapi' => 'required|string',
            'tglPeriksa' => 'required|date',
        ]);

        $rekamMedis = Book_RM::findOrFail($id);
        $rekamMedis->update(array_merge($validatedData, ['userId' => auth()->id()]));

        return redirect()->route('rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $rekamMedis = Book_RM::findOrFail($id);
        $rekamMedis->delete();

        return redirect()->route('rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
