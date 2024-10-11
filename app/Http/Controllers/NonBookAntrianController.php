<?php

namespace App\Http\Controllers;

use App\Models\NonBookAntrian;
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

        // Return the view with non-bookantrian data
        return view('admin.NonBookAntrian.index', compact('nonBookAntrians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the view to create a new non-bookantrian record
        return view('admin.NonBookAntrian.create');
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
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'status' => 'nullable|string|max:50',
        ]);
    
        // Get the last non-bookantrian record's no_antrian and tanggal_kunjungan
        $lastRecord = NonBookAntrian::orderBy('id', 'desc')->first();
    
        // Generate the next no_antrian
        $nextNoAntrian = 'B1'; // Default value
        $newDate = \Carbon\Carbon::parse($request->tanggal_kunjungan); // Use fully qualified class name
    
        if ($lastRecord) {
            // Extract the date and no_antrian
            $lastDate = \Carbon\Carbon::parse($lastRecord->tanggal_kunjungan); // Use fully qualified class name
            $lastNoAntrian = $lastRecord->no_antrian;
    
            // Check if the new date is different from the last record's date
            if ($newDate->toDateString() !== $lastDate->toDateString()) {
                // Reset no_antrian to B1 if the date is different
                $nextNoAntrian = 'B1';
            } else {
                // Extract the numeric part and increment
                $lastNumber = intval(substr($lastNoAntrian, 1)); // Remove the 'B' and convert to integer
                $nextNumber = $lastNumber + 1; // Increment
                $nextNoAntrian = 'B' . $nextNumber; // Create new no_antrian
            }
        }
    
        // Store the new non-bookantrian record in the database
        NonBookAntrian::create(array_merge($validatedData, [
            'no_antrian' => $nextNoAntrian,
            'user_id' => auth()->id()
        ]));
    
        // Redirect to the index page with success message
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
