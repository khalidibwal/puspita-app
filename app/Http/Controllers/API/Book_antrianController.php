<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookAntrian;
use Illuminate\Support\Facades\Auth;

class Book_antrianController extends Controller
{
    /**
     * List all BookAntrian records for the logged-in user.
     */
    public function index()
    {
        // Fetch all book antrian records for the logged-in user
        $bookantrian = BookAntrian::where('user_id', Auth::id())->get();

        return response()->json([
            'message' => 'All BookAntrian records fetched successfully',
            'data' => $bookantrian,
        ], 200);
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
    ]);

    // Get the last `no_antrian` value from the database
    $lastAntrian = BookAntrian::whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
        ->orderBy('no_antrian', 'desc')
        ->first();

    // If no record exists for that day, start with A1; otherwise, increment it
    if ($lastAntrian) {
        // Extract the numeric part of the last `no_antrian`
        $lastAntrianNumber = (int) substr($lastAntrian->no_antrian, 1);
        // Increment it by 1 and append the letter "A"
        $newAntrian = 'A' . ($lastAntrianNumber + 1);
    } else {
        // Start with A1 if no previous antrian exists for that day
        $newAntrian = 'A1';
    }

    // Create new BookAntrian record with the generated `no_antrian`
    $bookantrian = BookAntrian::create([
        'no_antrian' => $newAntrian,
        'keluhan' => $request->keluhan,
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'status' => 'PENDING', // Default status
        'user_id' => auth()->id(),  // Automatically insert the logged-in user's ID
    ]);

    return response()->json([
        'message' => 'BookAntrian record created successfully',
        'data' => $bookantrian,
    ], 201);
}


    /**
     * Show a specific BookAntrian record by ID.
     */
    public function show($userId)
{
    try {
        // Check if the authenticated user is trying to access their own data
        if (Auth::id() != $userId) {
            return response()->json([
                'message' => 'Unauthorized access to BookAntrian data',
            ], 403); // 403 Forbidden
        }

        // Fetch the bookantrian records for the specific user ID and include user details
        $bookantrians = BookAntrian::with('user')
            ->where('user_id', $userId)
            ->get();

        // Check if there are any records for this user
        if ($bookantrians->isEmpty()) {
            return response()->json([
                'message' => 'No BookAntrian records found for this user'
            ], 404);
        }

        return response()->json([
            'message' => 'BookAntrian records found',
            'data' => $bookantrians,
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Error finding BookAntrian records',
            'error' => $e->getMessage(),
        ], 500); // 500 Internal Server Error
    }
}




    /**
     * Update a specific BookAntrian record.
     */
    public function update(Request $request, $id)
    {
        // Find the BookAntrian record
        $bookantrian = BookAntrian::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validate the request
        $request->validate([
            'no_antrian' => 'required|string|max:20',
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'status' => 'nullable|string|max:50',
        ]);

        // Update the record
        $bookantrian->update([
            'no_antrian' => $request->no_antrian,
            'keluhan' => $request->keluhan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status' => $request->status ?? 'PENDING',
        ]);

        return response()->json([
            'message' => 'BookAntrian record updated successfully',
            'data' => $bookantrian,
        ], 200);
    }

    /**
     * Delete a specific BookAntrian record.
     */
    public function destroy($id)
    {
        // Find the record to delete
        $bookantrian = BookAntrian::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete the record
        $bookantrian->delete();

        return response()->json([
            'message' => 'BookAntrian record deleted successfully',
        ], 200);
    }
}
