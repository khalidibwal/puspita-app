<?php

namespace App\Http\Controllers;

use App\Models\BookAntrian;
use App\Models\ApiUser;
use App\Models\medikaPoliklinik;
use App\Models\NonBookAntrian; // Import the NonBookAntrian model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookAntrianController extends Controller
{
    /**
     * Display a list of BookAntrian records for the logged-in user.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $bookantrians = BookAntrian::with(['poliklinik', 'user']) // Load relationships
            ->when($search, function($query, $search) {
                return $query->where('status', 'LIKE', "%{$search}%");
            })->paginate(10); // Adjust the pagination as necessary
    
        $poliklinik = medikaPoliklinik::all();
        $userApi = ApiUser::all();
    
        return view('admin.Bookantrian.index', compact('bookantrians', 'poliklinik', 'userApi'));
    }
    


    // public function showCurrentAntrian()
    // {
    // // Fetch the entry with status NOW
    // $currentAntrian = BookAntrian::where('status', 'NOW')->first();

    // // Return the Blade view with the currentAntrian
    // return view('admin.Bookantrian.booking-antrian', compact('currentAntrian'));
    // }
    // public function fetchCurrentAntrian()
    // {
    // // Fetch the entry with status NOW
    // $currentAntrian = BookAntrian::where('status', 'NOW')->first();

    // // Return only the necessary data for the AJAX request
    // return response()->json(['currentAntrian' => $currentAntrian]);
    // }
    // public function showCurrentAntrian()
    // {
    //     // Fetch the entry with status NOW from BookAntrian
    //     $currentAntrian = BookAntrian::where('status', 'NOW')->first();

    //     // Fetch the entry with status NOW from NonBookAntrian
    //     $currentOfflineAntrian = NonBookAntrian::where('status', 'NOW')->first();

    //     // Return the Blade view with both currentAntrian and currentOfflineAntrian
    //     return view('admin.Bookantrian.booking-antrian', compact('currentAntrian', 'currentOfflineAntrian'));
    // }

    // public function fetchCurrentAntrian()
    // {
    //     // Fetch the entry with status NOW from BookAntrian
    //     $currentAntrian = BookAntrian::where('status', 'NOW')->first();
        
    //     // Fetch the entry with status NOW from NonBookAntrian
    //     $currentOfflineAntrian = NonBookAntrian::where('status', 'NOW')->first();

    //     // Return only the necessary data for the AJAX request
    //     return response()->json([
    //         'currentAntrian' => $currentAntrian,
    //         'currentOfflineAntrian' => $currentOfflineAntrian
    //     ]);
    // }
    public function showCurrentAntrian()
{
    // Get today's date
    $today = now()->format('Y-m-d');

    // Fetch the entry with status NOW and today's date from BookAntrian
    $currentAntrian = BookAntrian::where('status', 'NOW')
        ->whereDate('created_at', $today)
        ->first();

    // Fetch the entry with status NOW and today's date from NonBookAntrian
    $currentOfflineAntrian = NonBookAntrian::where('status', 'NOW')
        ->whereDate('created_at', $today)
        ->first();

    // Return the Blade view with both currentAntrian and currentOfflineAntrian
    return view('admin.Bookantrian.booking-antrian', compact('currentAntrian', 'currentOfflineAntrian'));
}

public function fetchCurrentAntrian()
{
    // Get today's date
    $today = now()->format('Y-m-d');

    // Fetch the entry with status NOW and today's date from BookAntrian
    $currentAntrian = BookAntrian::where('status', 'NOW')
        ->whereDate('created_at', $today)
        ->first();
    
    // Fetch the entry with status NOW and today's date from NonBookAntrian
    $currentOfflineAntrian = NonBookAntrian::where('status', 'NOW')
        ->whereDate('created_at', $today)
        ->first();

    // Return only the necessary data for the AJAX request
    return response()->json([
        'currentAntrian' => $currentAntrian,
        'currentOfflineAntrian' => $currentOfflineAntrian
    ]);
}

     // New function to return JSON data FOR API
     public function getCurrentAntrianJson()
     {
         // Get today's date
    $today = now()->format('Y-m-d');

    // Fetch the entry with status NOW and today's date from BookAntrian
    $currentAntrian = BookAntrian::where('status', 'NOW')
        ->whereDate('created_at', $today)
        ->first();
    
    // Fetch the entry with status NOW and today's date from NonBookAntrian
    $currentOfflineAntrian = NonBookAntrian::where('status', 'NOW')
        ->whereDate('created_at', $today)
        ->first();

    // Return only the necessary data for the AJAX request
    return response()->json([
        'currentAntrian' => $currentAntrian,
        'currentOfflineAntrian' => $currentOfflineAntrian
    ]);
     }


    /**
     * Show the form for creating a new BookAntrian record.
     */
    public function create()
    {
        // Return the view for creating a new book antrian
        return view('Admin.Bookantrian.create');
    }

    /**
     * Store a new BookAntrian record.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'waktu_kunjungan' => 'required|string',
            'alergi' => 'required|string',
            'poliklinikId' => 'required|integer|exists:poliklinik,idPoliklinik', // Validate foreign key
            'dokterNip' => 'required|integer|exists:dokter,nip', // Validate foreign key
        ]);

        // Get the last `no_antrian` value from the database for the specific date
        $lastAntrian = BookAntrian::whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->orderBy('no_antrian', 'desc')
            ->first();

        // Generate the next `no_antrian`
        if ($lastAntrian) {
            $lastAntrianNumber = (int) substr($lastAntrian->no_antrian, 1);
            $newAntrian = 'A' . ($lastAntrianNumber + 1);
        } else {
            $newAntrian = 'A1';
        }

        // Create the new BookAntrian record
        $bookantrian = BookAntrian::create([
            'no_antrian' => $newAntrian,
            'keluhan' => $request->keluhan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'waktu_kunjungan' => $request->waktu_kunjungan,
            'alergi' => $request->alergi,
            'status' => 'PENDING',
            'user_id' => Auth::id(),
            'poliklinikId' => $request->poliklinikId, // Include foreign key
            'dokterNip' => $request->dokterNip, // Include foreign key
            
        ]);

        // Redirect to the index page with success message
        return redirect()->route('bookantrian.index')
            ->with('success', 'BookAntrian created successfully.');
    }

    /**
     * Display a specific BookAntrian record.
     */
    public function show($id)
    {
        // Find the BookAntrian record
        $bookantrian = BookAntrian::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Return the view with the book antrian data
        return view('Admin.Bookantrian.show', compact('bookantrian'));
    }

    /**
     * Show the form for editing a BookAntrian record.
     */
    public function edit($id)
    {
        // Find the BookAntrian record
        $bookantrian = BookAntrian::where('id', $id)
            ->firstOrFail();

        // Return the view for editing the book antrian
        return view('admin.Bookantrian.edit', compact('bookantrian'));
    }

    /**
     * Update a specific BookAntrian record.
     */
//     public function update(Request $request, $id)
// {
//     try {
//         // Validate the status input
//         $validatedData = $request->validate([
//             'status' => 'required|string|in:PENDING,COMPLETED,CANCELLED,NOW', // Status must be one of these values
//         ]);

//         // Check if the status is 'NOW'
//         if ($validatedData['status'] === 'NOW') {
//             // Check if any BookAntrian record already has the status 'NOW'
//             $hasNowStatus = BookAntrian::where('status', 'NOW')->exists();

//             if ($hasNowStatus) {
//                 // If there's already a record with status 'NOW', prevent the update
//                 return redirect()->back()->withErrors(['status' => 'Tidak Dapat di ganti status SEKARANG/NOW karna ada ANTRIAN YANG BELUM DI UPDATE']);
//             }
//         }

//         // Find the BookAntrian record
//         $bookantrian = BookAntrian::findOrFail($id);

//         // Allow updates to COMPLETED, PENDING, or CANCELLED without restriction
//         if (in_array($validatedData['status'], ['COMPLETED', 'PENDING', 'CANCELLED'])) {
//             $bookantrian->status = $validatedData['status'];
//         } elseif ($validatedData['status'] === 'NOW' && !$hasNowStatus) {
//             // If status is NOW and no other record has 'NOW', allow the update
//             $bookantrian->status = 'NOW';
//         }

//         // Save the updated status
//         $bookantrian->save();

//         return redirect()->route('bookantrian.index')->with('success', 'Book Antrian status updated successfully!');
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         // Handle case where the record is not found
//         return redirect()->back()->withErrors(['status' => 'Book Antrian record not found.']);
//     } catch (\Exception $e) {
//         // Log the error for debugging
//         \Log::error('Error updating Book Antrian status: ' . $e->getMessage());

//         // Return a generic error response
//         return redirect()->back()->withErrors(['status' => 'Failed to update Book Antrian status. Please try again later.']);
//     }
// }

public function update(Request $request, $id)
{
    try {
        // Validate the status input
        $validatedData = $request->validate([
            'status' => 'required|string|in:PENDING,COMPLETED,CANCELLED,NOW', // Status must be one of these values
        ]);

        // Find the BookAntrian record
        $bookantrian = BookAntrian::findOrFail($id);

        // Check if the status is 'NOW'
        if ($validatedData['status'] === 'NOW') {
            // If the current status is not NOW, change other records to PENDING
            if ($bookantrian->status !== 'NOW') {
                // Update any existing NOW status to PENDING
                BookAntrian::where('status', 'NOW')->update(['status' => 'PENDING']);
            }
        }

        // Allow updates to COMPLETED, PENDING, or CANCELLED without restriction
        $bookantrian->status = $validatedData['status'];

        // Save the updated status
        $bookantrian->save();

        return redirect()->route('bookantrian.index')->with('success', 'Book Antrian status updated successfully!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle case where the record is not found
        return redirect()->back()->withErrors(['status' => 'Book Antrian record not found.']);
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error updating Book Antrian status: ' . $e->getMessage());

        // Return a generic error response
        return redirect()->back()->withErrors(['status' => 'Failed to update Book Antrian status. Please try again later.']);
    }
}




    /**
     * Delete a specific BookAntrian record.
     */
    public function destroy($id)
    {
        // Find the BookAntrian record
        $bookantrian = BookAntrian::where('id', $id)
            ->firstOrFail();

        // Delete the record
        $bookantrian->delete();

        // Redirect to the index page with success message
        return redirect()->route('bookantrian.index')
            ->with('success', 'BookAntrian deleted successfully.');
    }
}
