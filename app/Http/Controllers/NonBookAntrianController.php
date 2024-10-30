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
    // Paginate non-bookantrian records, 10 records per page (adjust as needed)
    $nonBookAntrians = NonBookAntrian::paginate(10);
    $pasiens = medikaPasien::all(); // Assuming you don't need pagination for pasiens

    // Return the view with paginated non-bookantrian data
    return view('admin.NonBookAntrian.index', compact('nonBookAntrians', 'pasiens'));
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
    try {
        // Validate the status input
        $validatedData = $request->validate([
            'status' => 'required|string|in:PENDING,COMPLETED,CANCELLED,NOW', // Status must be one of these values
        ]);

        // Check if the status is 'NOW'
        if ($validatedData['status'] === 'NOW') {
            // Check if any NonBookAntrian record already has the status 'NOW'
            $hasNowStatus = NonBookAntrian::where('status', 'NOW')->exists();

            if ($hasNowStatus) {
                // If there's already a record with status 'NOW', prevent the update
                return redirect()->back()->withErrors(['status' => 'Tidak Dapat di ganti status SEKARANG/NOW karna ada ANTRIAN YANG BELUM DI UPDATE']);
            }
        }

        // Find the NonBookAntrian record
        $nonBookAntrian = NonBookAntrian::findOrFail($id);

        // Allow updates to COMPLETED, PENDING, or CANCELLED without restriction
        if (in_array($validatedData['status'], ['COMPLETED', 'PENDING', 'CANCELLED'])) {
            $nonBookAntrian->status = $validatedData['status'];
        } elseif ($validatedData['status'] === 'NOW' && !$hasNowStatus) {
            // If status is NOW and no other record has 'NOW', allow the update
            $nonBookAntrian->status = 'NOW';
        }

        // Save the updated status
        $nonBookAntrian->save();

        return redirect()->route('non_bookantrian.index')->with('success', 'Non-BookAntrian status updated successfully!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle case where the record is not found
        return redirect()->back()->withErrors(['status' => 'Non-BookAntrian record not found.']);
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error updating Non-BookAntrian status: ' . $e->getMessage());

        // Return a generic error response
        return redirect()->back()->withErrors(['status' => 'Failed to update Non-BookAntrian status. Please try again later.']);
    }
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
