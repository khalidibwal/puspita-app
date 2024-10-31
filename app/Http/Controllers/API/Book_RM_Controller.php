<?php

namespace App\Http\Controllers\API;

use App\Models\Book_RM;
use Illuminate\Support\Facades\Auth;
use App\Models\medikaDokter;
use App\Models\medikaPoliklinik;
use App\Models\ApiUser; // Use the ApiUser model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Book_RM_Controller extends Controller
{
    public function index(Request $request)
    {
        // Fetch only records belonging to the authenticated user
        $records = Book_RM::where('userId', Auth::id())
            ->with(['dokter', 'poliklinik']) // Eager load relationships if needed
            ->get(); // Paginate results

        return response()->json($records);
    }

    // Get a specific record by ID for the authenticated user
    public function show($id)
    {
        $record = Book_RM::where('idRekamMedis', $id)
            ->where('userId', Auth::id())
            ->with(['dokter', 'poliklinik']) // Eager load relationships if needed
            ->first();

        if (!$record) {
            return response()->json(['error' => 'Record not found or access denied.'], 404);
        }

        return response()->json($record);
    }
}
