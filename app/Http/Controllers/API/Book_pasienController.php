<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookPasien;
use Illuminate\Support\Facades\Auth;
use Exception;

class Book_pasienController extends Controller
{
    /**
     * List all bookpasien records.
     */
    public function index()
    {
        try {
            // Fetch all BookPasien records for the logged-in user
            // $bookpasiens = BookPasien::where('user_id', Auth::id())->get();
            $bookpasiens = BookPasien::with('user')->where('user_id', Auth::id())->get();

            return response()->json([
                'message' => 'All BookPasien records fetched successfully',
                'data' => $bookpasiens,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error fetching BookPasien records',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new bookpasien record.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'namaPasien' => 'required|string|max:255',
                'NIK' => 'required|string|max:255|unique:bookpasien',
                'jenisKelamin' => 'required|string|max:255',
                'noTelp' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'foto' => 'nullable|string',
            ]);

            // Create new bookpasien record
            $bookpasien = BookPasien::create([
                'namaPasien' => $request->namaPasien,
                'NIK' => $request->NIK,
                'jenisKelamin' => $request->jenisKelamin,
                'noTelp' => $request->noTelp,
                'alamat' => $request->alamat,
                'noBPJS' => $request->noBPJS,
                'foto' => $request->foto,
                'user_id' => auth()->id(),  // Automatically insert the logged-in user's ID
            ]);

            return response()->json([
                'message' => 'BookPasien record created successfully',
                'data' => $bookpasien,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating BookPasien record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show a specific bookpasien record by ID.
     */
    public function show($userId)
{
    try {
        // Get the logged-in user
        $loggedInUserId = Auth::id();

        // Allow access to the logged-in user's own records
        if ($loggedInUserId == $userId || Auth::user()->is_admin) {
            // Fetch BookPasien records for the given userId and include user details
            $bookpasiens = BookPasien::where('user_id', $userId)
                ->with('user') // Eager load user details
                ->get();

            if ($bookpasiens->isEmpty()) {
                return response()->json([
                    'message' => 'No BookPasien records found for this user',
                ], 404);
            }

            return response()->json([
                'message' => 'BookPasien records found for the user',
                'data' => $bookpasiens,
            ], 200);
        }

        // If not admin and not the same user, deny access
        return response()->json([
            'message' => 'Unauthorized access to BookPasien records',
        ], 403); // 403 Forbidden

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while fetching the BookPasien records',
            'error' => $e->getMessage(),
        ], 500);
    }
}






    /**
     * Update a specific bookpasien record.
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the record to update
            $bookpasien = BookPasien::where('id', $id)
                ->where('user_id', Auth::id()) // Ensure it belongs to the logged-in user
                ->firstOrFail();

            // Validate the request
            $request->validate([
                'namaPasien' => 'required|string|max:255',
                'NIK' => 'required|string|max:255|unique:bookpasien,NIK,' . $bookpasien->id,
                'jenisKelamin' => 'required|string|max:255',
                'noTelp' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'foto' => 'nullable|string',
            ]);

            // Update the record
            $bookpasien->update([
                'namaPasien' => $request->namaPasien,
                'NIK' => $request->NIK,
                'jenisKelamin' => $request->jenisKelamin,
                'noTelp' => $request->noTelp,
                'alamat' => $request->alamat,
                'noBPJS' => $request->noBPJS,
                'foto' => $request->foto,
            ]);

            return response()->json([
                'message' => 'BookPasien record updated successfully',
                'data' => $bookpasien,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating BookPasien record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a specific bookpasien record.
     */
    public function destroy($id)
    {
        try {
            // Find the record to delete
            $bookpasien = BookPasien::where('id', $id)
                ->where('user_id', Auth::id()) // Ensure it belongs to the logged-in user
                ->firstOrFail();

            // Delete the record
            $bookpasien->delete();

            return response()->json([
                'message' => 'BookPasien record deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting BookPasien record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
