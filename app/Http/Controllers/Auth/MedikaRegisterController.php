<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mymedika;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MedikaRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.mymedikaregister'); // Your custom registration view
    }
    public function register(Request $request)
    {
        // Validate form input
    $request->validate([
        'fullName' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:userlogin',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|integer',
        'active' => 'nullable|boolean',
    ]);

    // Create the user with hashed password
    $user = mymedika::create([
        'fullName' => $request->fullName,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'active' => $request->active ? 1 : 0, // Set active as 1 if checkbox is checked, otherwise 0
    ]);

    // Log the user in after successful registration
    Auth::login($user);

    // Redirect to the dashboard or any other page
    return redirect()->intended('/dashboard');
    }
}
