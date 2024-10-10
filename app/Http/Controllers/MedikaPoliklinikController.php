<?php

namespace App\Http\Controllers;

use App\Models\medikaPoliklinik; // Use the correct casing for the model
use Illuminate\Http\Request;

class MedikaPoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polikliniks = medikaPoliklinik::all(); // Fetch all records
        return view('admin.Poliklinik.index', compact('polikliniks')); // Return the view with records
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Poliklinik.create'); // Return the create form view
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
            'namaPoliklinik' => 'required|string|max:255',
            'gedung' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Create a new Poliklinik entry
        medikaPoliklinik::create($request->all());

        return redirect()->route('polikliniks.index')->with('success', 'Poliklinik berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poliklinik = medikaPoliklinik::findOrFail($id); // Fetch the specific Poliklinik
        return view('admin.Poliklinik.show', compact('poliklinik')); // Return the show view with the Poliklinik data
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poliklinik = medikaPoliklinik::findOrFail($id); // Fetch the specific Poliklinik for editing
        return view('admin.Poliklinik.edit', compact('poliklinik')); // Return the edit form view
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
            'namaPoliklinik' => 'required|string|max:255',
            'gedung' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        $poliklinik = medikaPoliklinik::findOrFail($id); // Fetch the Poliklinik to update
        $poliklinik->update($request->all()); // Update the Poliklinik with new data

        return redirect()->route('polikliniks.index')->with('success', 'Poliklinik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poliklinik = medikaPoliklinik::findOrFail($id); // Fetch the specific Poliklinik
        $poliklinik->delete(); // Delete the Poliklinik

        return redirect()->route('polikliniks.index')->with('success', 'Poliklinik berhasil dihapus!');
    }
}
