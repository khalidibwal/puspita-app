<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\medikaDokter;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get search query from the request
        $search = $request->input('search');

        // Get all dokters, filtering by search query and applying pagination
        $dokters = medikaDokter::where('namaDokter', 'like', '%' . $search . '%')
            ->orWhere('nip', 'like', '%' . $search . '%')
            ->orWhere('spesialis', 'like', '%' . $search . '%')
            ->paginate(10); // Adjust the number of items per page as needed

        // Return the result as JSON
        return response()->json($dokters);
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
            'nip' => 'required|string|unique:dokter,nip',
            'namaDokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'email' => 'required|email|unique:dokter,email',
            'noTelp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'fotoDokter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'biayaDokter' => 'required|integer',
        ]);

        // Handle file upload if there's an image
        if ($request->hasFile('fotoDokter')) {
            $fileName = time() . '.' . $request->fotoDokter->extension();
            $request->fotoDokter->move(public_path('images'), $fileName);
        } else {
            $fileName = null;
        }

        // Create the new doctor
        $dokter = medikaDokter::create([
            'nip' => $request->nip,
            'namaDokter' => $request->namaDokter,
            'spesialis' => $request->spesialis,
            'email' => $request->email,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
            'fotoDokter' => $fileName,
            'biayaDokter' => $request->biayaDokter,
        ]);

        return response()->json([
            'message' => 'Doctor created successfully.',
            'dokter' => $dokter
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $dokter = medikaDokter::findOrFail($id);

        return response()->json($dokter);
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
            'nip' => 'required|string|unique:dokter,nip,' . $id . ',nip',
            'namaDokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'email' => 'required|email|unique:dokter,email,' . $id . ',nip',
            'noTelp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'fotoDokter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'biayaDokter' => 'required|integer',
        ]);

        // Find the doctor
        $dokter = medikaDokter::findOrFail($id);

        // Handle file upload if there's an image
        if ($request->hasFile('fotoDokter')) {
            $fileName = time() . '.' . $request->fotoDokter->extension();
            $request->fotoDokter->move(public_path('images'), $fileName);
            $dokter->fotoDokter = $fileName; // Update with the new filename
        }

        // Update doctor details
        $dokter->update([
            'nip' => $request->nip,
            'namaDokter' => $request->namaDokter,
            'spesialis' => $request->spesialis,
            'email' => $request->email,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
            'biayaDokter' => $request->biayaDokter,
        ]);

        return response()->json([
            'message' => 'Doctor updated successfully.',
            'dokter' => $dokter
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
        $dokter = medikaDokter::findOrFail($id);
        $dokter->delete();

        return response()->json([
            'message' => 'Doctor deleted successfully.'
        ]);
    }
}
