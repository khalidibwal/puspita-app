<?php

namespace App\Http\Controllers\lab;

use App\Http\Controllers\Controller;
use App\Models\lab\jenisPK;
use App\Models\lab\labCategory;
use Illuminate\Http\Request;

class JenisPKController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch all data with search and pagination
        $jenisPK = jenisPK::with('labCategory') // Eager load the labCategory relationship
            ->when($search, function ($query) use ($search) {
                return $query->where('jenisPK', 'like', '%' . $search . '%'); // Search by jenisPK name
            })
            ->paginate(10); // Adjust the number of items per page as needed

        return view('admin.Laboratorium.JenisPK.index', compact('jenisPK', 'search'));
    }
    public function create()
    {
        // Mengambil semua sub kategori lab untuk dropdown pada form
        $labCategory = labCategory::all();
        return view('admin.Laboratorium.JenisPK.create', compact('labCategory'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenisPK' => 'required|string|max:255',
            'nilaiNormal' => 'required|string|max:255',
            'sub_category_lab_id' => 'required|exists:sub_category_lab,id',
        ]);

        // Membuat record baru di tabel lab_tests
        jenisPK::create([
            'jenisPK' => $request->jenisPK,
            'nilaiNormal' => $request->nilaiNormal,
            'sub_category_lab_id' => $request->sub_category_lab_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jenis_pemeriksaan.index')->with('success', 'Lab test created successfully.');
    }
    public function edit($id)
    {
        // Mengambil data sub kategori lab untuk dropdown
        $labCategory = labCategory::all();
        $jenisPK = jenisPK::findOrFail($id);
        return view('admin.Laboratorium.JenisPK.edit', compact('jenisPK', 'labCategory'));
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData =  $request->validate([
            'jenisPK' => 'required|string|max:255',
            'nilaiNormal' => 'required|string|max:255',
            'sub_category_lab_id' => 'required|exists:sub_category_lab,id',
        ]);

        // Update data lab test
        $jenisPK = jenisPK::findOrFail($id);
        $jenisPK->update($validatedData);
        // $jenisPK->update([
        //     'jenisPK' => $request->jenisPK,
        //     'nilaiNormal' => $request->nilaiNormal,
        //     'sub_category_lab_id' => $request->sub_category_lab_id,
        // ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jenis_pemeriksaan.index')->with('success', 'Lab test updated successfully.');
    }
    public function destroy($id)
    {
        // Menghapus lab test
        $jenisPK = jenisPK::findOrFail($id);
        $jenisPK->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jenis_pemeriksaan.index')->with('success', 'Lab test deleted successfully.');
    }
}
