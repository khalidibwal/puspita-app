<?php

namespace App\Http\Controllers;

use App\Models\medikaObat; // Import your MedikaObat model
use Illuminate\Http\Request;

class MedikaObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $search = $request->input('search');

    // Fetch all medika obat records with search and pagination
    $medikaObats = medikaObat::when($search, function ($query) use ($search) {
        return $query->where('namaObat', 'like', '%' . $search . '%');
    })->paginate(10); // Adjust the number of items per page as needed

    return view('admin.Obat.index', compact('medikaObats', 'search')); // Pass the search term to the view
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Obat.create'); // Adjust the view path as necessary
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'namaObat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Create a new medika obat record
        medikaObat::create($request->all());

        return redirect()->route('obats.index')->with('success', 'Medika Obat created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medikaObat = medikaObat::findOrFail($id);
        return view('admin.Obat.show', compact('medikaObat')); // Adjust the view path as necessary
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medikaObat = medikaObat::findOrFail($id);
        return view('admin.Obat.edit', compact('medikaObat')); // Adjust the view path as necessary
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'namaObat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Find the medika obat record and update it
        $medikaObat = medikaObat::findOrFail($id);
        $medikaObat->update($request->all());

        return redirect()->route('obats.index')->with('success', 'Medika Obat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the medika obat record and delete it
        $medikaObat = medikaObat::findOrFail($id);
        $medikaObat->delete();

        return redirect()->route('obats.index')->with('success', 'Medika Obat deleted successfully.');
    }
}
