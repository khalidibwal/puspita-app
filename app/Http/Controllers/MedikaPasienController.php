<?php

namespace App\Http\Controllers;

use App\Models\medikaPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedikaPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all pasien records from the database
        $pasiens = medikaPasien::all();
        
        // Return the view with pasien data
        return view('admin.Pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the view to create a new pasien
        return view('admin.Pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        medikaPasien::create($validatedData);

        // Redirect to the index page with success message
        return redirect()->route('pasiens.index')->with('success', 'Pasien created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find pasien by id
        $pasien = medikaPasien::findOrFail($id);

        // Return the view to show the pasien details
        return view('admin.Pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find pasien by id
        $pasien = medikaPasien::findOrFail($id);

        // Return the view to edit the pasien
        return view('admin.Pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    // Redirect to the index page with success message
    return redirect()->route('pasiens.index')->with('success', 'Pasien updated successfully.');
}




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find pasien by id and delete it
        $pasien = medikaPasien::findOrFail($id);
        $pasien->delete();

        // Redirect to the index page with success message
        return redirect()->route('pasiens.index')->with('success', 'Pasien deleted successfully.');
    }
}
