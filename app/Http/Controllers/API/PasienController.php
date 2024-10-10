<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\medikaPasien;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get all pasien records from the database
        $pasiens = medikaPasien::all();

        // Return the pasien data as JSON
        return response()->json([
            'success' => true,
            'data' => $pasiens
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'namaPasien' => 'required',
            'NIK' => 'required|unique:pasien,NIK',
            'jenisKelamin' => 'required',
            'email' => 'required|email|unique:pasien,email',
            'noTelp' => 'required',
            'alamat' => 'nullable',
            'noBPJS' => 'required|numeric',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Store the new pasien record in the database
        $pasien = medikaPasien::create($validatedData);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Pasien created successfully.',
            'data' => $pasien
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Find pasien by id
        $pasien = medikaPasien::findOrFail($id);

        // Return the pasien details as JSON
        return response()->json([
            'success' => true,
            'data' => $pasien
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idPasien
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $idPasien)
    {
        // Find pasien by idPasien
        $pasien = medikaPasien::findOrFail($idPasien);

        // Validate the request data
        $validatedData = $request->validate([
            'namaPasien' => 'required',
            'NIK' => 'required|unique:pasien,NIK,' . $pasien->idPasien . ',idPasien', // Specify the primary key
            'jenisKelamin' => 'required',
            'email' => 'required|email|unique:pasien,email,' . $idPasien . ',idPasien', // Specify the primary key
            'noTelp' => 'required',
            'alamat' => 'nullable',
            'noBPJS' => 'required|numeric',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Update the pasien record
        $pasien->update($validatedData);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Pasien updated successfully.',
            'data' => $pasien
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
        // Find pasien by id and delete it
        $pasien = medikaPasien::findOrFail($id);
        $pasien->delete();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Pasien deleted successfully.'
        ]);
    }
}
