<?php

namespace App\Http\Controllers;

use App\Models\NonBookAntrian;
use App\Models\medikaPasien;
use Illuminate\Http\Request;

class NonBookAntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all non-bookantrian records from the database
        $nonBookAntrians = NonBookAntrian::all();
        $pasiens = medikaPasien::all();

        // Return the view with non-bookantrian data
        return view('admin.NonBookAntrian.index', compact('nonBookAntrians','pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pasiens = medikaPasien::all();
        // Return the view to create a new non-bookantrian record
        return view('admin.NonBookAntrian.create',compact('pasiens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         // Validate the request data, including the pasienId
         $validatedData = $request->validate([
             'pasien_id' => 'required|exists:pasien,idPasien', // Validate pasien_id exists in the pasien table
             'keluhan' => 'required|string',
             'tanggal_kunjungan' => 'required|date',
             'status' => 'nullable|string|max:50',
         ]);
     
         // Get the last non-bookantrian record's no_antrian and tanggal_kunjungan
         $lastRecord = NonBookAntrian::orderBy('id', 'desc')->first();
     
         // Generate the next no_antrian
         $nextNoAntrian = 'B1'; // Default value
         $newDate = \Carbon\Carbon::parse($request->tanggal_kunjungan); // Parse the date
     
         if ($lastRecord) {
             // Extract the date and no_antrian
             $lastDate = \Carbon\Carbon::parse($lastRecord->tanggal_kunjungan);
             $lastNoAntrian = $lastRecord->no_antrian;
     
             // Check if the new date is different from the last record's date
             if ($newDate->toDateString() !== $lastDate->toDateString()) {
                 $nextNoAntrian = 'B1'; // Reset no_antrian for a new day
             } else {
                 // Increment the numeric part of no_antrian
                 $lastNumber = intval(substr($lastNoAntrian, 1)); // Remove the 'B' and convert to integer
                 $nextNumber = $lastNumber + 1;
                 $nextNoAntrian = 'B' . $nextNumber; // Create new no_antrian
             }
         }
     
         // Store the new non-bookantrian record with pasien_id
         NonBookAntrian::create(array_merge($validatedData, [
             'no_antrian' => $nextNoAntrian,
         ]));
     
         // Redirect to the index page with a success message
         return redirect()->route('non_bookantrian.index')->with('success', 'Non-BookAntrian record created successfully.');
     }
     
    



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the non-bookantrian record by id
        $nonBookAntrian = NonBookAntrian::findOrFail($id);

        // Return the view to show the non-bookantrian details
        return view('admin.NonBookAntrian.show', compact('nonBookAntrian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the non-bookantrian record by id
        $nonBookAntrian = NonBookAntrian::findOrFail($id);

        // Return the view to edit the non-bookantrian record
        return view('admin.NonBookAntrian.edit', compact('nonBookAntrian'));
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
        // Find the non-bookantrian record by id
        $nonBookAntrian = NonBookAntrian::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'no_antrian' => 'required|string|max:20',
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'status' => 'nullable|string|max:50',
        ]);

        // Update the non-bookantrian record
        $nonBookAntrian->update($validatedData);

        // Redirect to the index page with success message
        return redirect()->route('non_bookantrian.index')->with('success', 'Non-BookAntrian record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the non-bookantrian record by id and delete it
        $nonBookAntrian = NonBookAntrian::findOrFail($id);
        $nonBookAntrian->delete();

        // Redirect to the index page with success message
        return redirect()->route('non_bookantrian.index')->with('success', 'Non-BookAntrian record deleted successfully.');
    }
}
