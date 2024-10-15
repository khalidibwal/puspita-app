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
        $validatedData = $request->validate([
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'poliklinikId' => 'required|integer|exists:poliklinik,idPoliklinik', // Ensure poliklinikId exists in the poliklinik table
        ]);

        // Get the last `no_antrian` value from the database
        $lastAntrian = BookAntrian::whereDate('tanggal_kunjungan', $validatedData['tanggal_kunjungan'])
            ->orderBy('no_antrian', 'desc')
            ->first();

        // Generate the next `no_antrian`
        $newAntrian = $lastAntrian 
            ? 'A' . ((int) substr($lastAntrian->no_antrian, 1) + 1) 
            : 'A1';

        // Create new BookAntrian record
        $bookantrian = BookAntrian::create([
            'no_antrian' => $newAntrian,
            'keluhan' => $validatedData['keluhan'],
            'tanggal_kunjungan' => $validatedData['tanggal_kunjungan'],
            'status' => 'PENDING',
            'user_id' => Auth::id(),
            'poliklinikId' => $validatedData['poliklinikId'], // Add poliklinikId here
        ]);

        return response()->json([
            'message' => 'BookAntrian record created successfully',
            'data' => $bookantrian,
        ], 201);
    }

    /**
     * Show a specific BookAntrian record by ID.
     */
    public function show($id)
{
    // Fetch the BookAntrian record along with user and poliklinik details
    $bookantrian = BookAntrian::with('user', 'poliklinik')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return response()->json([
        'message' => 'BookAntrian record found',
        'data' => $bookantrian,
    ], 200);
}


    /**
     * Update a specific BookAntrian record.
     */
    public function update(Request $request, $id)
{
    try {
        // Find the BookAntrian record for the authenticated user
        $bookantrian = BookAntrian::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validate the status input
        $validatedData = $request->validate([
            'status' => 'required|string|in:PENDING,NOW,COMPLETED,CANCELED', // Status must be one of these values
        ]);

        // Update only the status field
        $bookantrian->status = $validatedData['status'];
        $bookantrian->save();

        return response()->json([
            'message' => 'BookAntrian status updated successfully',
            'data' => $bookantrian,
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle case where the record is not found
        return response()->json([
            'message' => 'BookAntrian record not found',
        ], 404);

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error updating BookAntrian status: ' . $e->getMessage());

        // Return a generic error response
        return response()->json([
            'message' => 'Failed to update BookAntrian status. Please try again later.',
            'error' => $e->getMessage(),
        ], 500);
    }
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
