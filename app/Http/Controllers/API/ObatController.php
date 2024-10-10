<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\medikaObat;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch all medika obat records with search and pagination
        $medikaObats = medikaObat::when($search, function ($query) use ($search) {
            return $query->where('namaObat', 'like', '%' . $search . '%');
        })->paginate(10); // Adjust the number of items per page as needed

        // Return paginated data as JSON
        return response()->json($medikaObats);
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
            'namaObat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Create a new medika obat record
        $medikaObat = medikaObat::create($request->all());

        // Return a JSON response with the created record
        return response()->json([
            'message' => 'Medika Obat created successfully.',
            'medikaObat' => $medikaObat,
        ], 201); // HTTP status 201: Created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $medikaObat = medikaObat::findOrFail($id);

        // Return a JSON response with the specified resource
        return response()->json($medikaObat);
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
            'namaObat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Find the medika obat record and update it
        $medikaObat = medikaObat::findOrFail($id);
        $medikaObat->update($request->all());

        // Return a JSON response with the updated record
        return response()->json([
            'message' => 'Medika Obat updated successfully.',
            'medikaObat' => $medikaObat,
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
        // Find the medika obat record and delete it
        $medikaObat = medikaObat::findOrFail($id);
        $medikaObat->delete();

        // Return a JSON response confirming deletion
        return response()->json([
            'message' => 'Medika Obat deleted successfully.'
        ]);
    }
}
