<?php

namespace App\Http\Controllers;

use App\Models\BookAntrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookAntrianController extends Controller
{
    /**
     * Display a list of BookAntrian records for the logged-in user.
     */
    public function index()
{
    // Fetch all book antrian records for the logged-in user, ordered by `tanggal_kunjungan` in descending order
    $bookantrians = BookAntrian::where('user_id', Auth::id())
        ->orderBy('tanggal_kunjungan', 'desc')
        ->paginate(5);

    // Return the view with the book antrian records
    return view('Admin.Bookantrian.index', compact('bookantrians'));
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
            'status' => 'PENDING',
            'user_id' => Auth::id(),
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
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Return the view for editing the book antrian
        return view('bookantrian.edit', compact('bookantrian'));
    }

    /**
     * Update a specific BookAntrian record.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'status' => 'nullable|string|max:50',
        ]);

        // Find the BookAntrian record
        $bookantrian = BookAntrian::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Update the record
        $bookantrian->update([
            'keluhan' => $request->keluhan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status' => $request->status ?? 'PENDING',
        ]);

        // Redirect to the index page with success message
        return redirect()->route('bookantrian.index')
            ->with('success', 'BookAntrian updated successfully.');
    }

    /**
     * Delete a specific BookAntrian record.
     */
    public function destroy($id)
    {
        // Find the BookAntrian record
        $bookantrian = BookAntrian::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete the record
        $bookantrian->delete();

        // Redirect to the index page with success message
        return redirect()->route('bookantrian.index')
            ->with('success', 'BookAntrian deleted successfully.');
    }
}
