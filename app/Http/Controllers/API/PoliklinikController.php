<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\medikaPoliklinik;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $polikliniks = medikaPoliklinik::all(); // Fetch all Poliklinik records
        return response()->json($polikliniks); // Return the data as JSON
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
        $poliklinik = medikaPoliklinik::create($request->all());

        // Return a JSON response with the newly created resource
        return response()->json([
            'message' => 'Poliklinik berhasil ditambahkan!',
            'poliklinik' => $poliklinik,
        ], 201); // 201: Created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $poliklinik = medikaPoliklinik::findOrFail($id); // Fetch the specific Poliklinik
        return response()->json($poliklinik); // Return the data as JSON
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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

        // Return a JSON response with the updated resource
        return response()->json([
            'message' => 'Poliklinik berhasil diperbarui!',
            'poliklinik' => $poliklinik,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $poliklinik = medikaPoliklinik::findOrFail($id); // Fetch the specific Poliklinik
        $poliklinik->delete(); // Delete the Poliklinik

        // Return a JSON response confirming the deletion
        return response()->json([
            'message' => 'Poliklinik berhasil dihapus!'
        ]);
    }
}
