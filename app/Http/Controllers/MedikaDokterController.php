<?php

namespace App\Http\Controllers;

use App\Models\medikaDokter; // Make sure to import your Dokter model
use Illuminate\Http\Request;

class MedikaDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    // Return the view with dokter data
    return view('admin.Dokter.index', compact('dokters', 'search'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Dokter.create'); // Adjust to your create view
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
            'nip' => 'required|string|unique:dokter,nip',
            'namaDokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'email' => 'required|email|unique:dokter,email',
            'noTelp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'fotoDokter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image
            // 'biayaDokter' => 'required|integer',
        ]);

        // Handle file upload if there's an image
        if ($request->hasFile('fotoDokter')) {
            $fileName = time() . '.' . $request->fotoDokter->extension();
            $request->fotoDokter->move(public_path('images'), $fileName);
        } else {
            $fileName = null; // Handle the case where no file is uploaded
        }

        // Create the new doctor
        medikaDokter::create([
            'nip' => $request->nip,
            'namaDokter' => $request->namaDokter,
            'spesialis' => $request->spesialis,
            'email' => $request->email,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
            'fotoDokter' => $fileName,
            'biayaDokter' => 0,
        ]);

        return redirect()->route('dokters.index')->with('success', 'Doctor created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dokter = medikaDokter::findOrFail($id);
        return view('admin.Dokter.show', compact('dokter')); // Adjust to your show view
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokter = medikaDokter::findOrFail($id);
        return view('admin.Dokter.edit', compact('dokter')); // Adjust to your edit view
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
            'nip' => 'required|string|unique:dokter,nip,' . $id . ',nip',
            'namaDokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'email' => 'required|email|unique:dokter,email,' . $id . ',nip',
            'noTelp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'fotoDokter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image
            // 'biayaDokter' => 'required|integer',
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
        $dokter->nip = $request->nip;
        $dokter->namaDokter = $request->namaDokter;
        $dokter->spesialis = $request->spesialis;
        $dokter->email = $request->email;
        $dokter->noTelp = $request->noTelp;
        $dokter->alamat = $request->alamat;
        // $dokter->biayaDokter = $request->biayaDokter;
        $dokter->save();

        return redirect()->route('dokters.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokter = medikaDokter::findOrFail($id);
        $dokter->delete();
        return redirect()->route('dokters.index')->with('success', 'Doctor deleted successfully.');
    }
}
