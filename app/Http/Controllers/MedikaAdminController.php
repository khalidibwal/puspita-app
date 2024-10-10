<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mymedika;

class MedikaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userlogin = mymedika::all();
        return view('admin.index', compact('userlogin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        mymedika::create([
            'fullName' => $request->fullName,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            // 'is_admin' => $request->is_admin ? 1 : 0,
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = mymedika::findOrFail($id);
        
        // Return the edit view with the user data
        return view('admin.edit', compact('user'));
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
        // Validate the request
        $request->validate([
            'fullName' => 'required',
            'username' => 'required|unique:userlogin,username',
            'password' => 'nullable|min:6',
            'role' => 'required|in:1,2', // Ensure role is either 1 or 2 (admin or user)
            'active' => 'nullable|boolean' // Optional active field, should be boolean
        ]);

        // Find the user by id
        $user = mymedika::findOrFail($id);
        
        // Update the user data
        $user->fullName = $request->fullName;
        $user->username = $request->username;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->role = $request->role ? 1 : 0;
        $user->save();

        return redirect()->route('admin.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = mymedika::findOrFail($id);
        
        // Delete the user
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
