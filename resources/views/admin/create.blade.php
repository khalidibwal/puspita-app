<!-- resources/views/admin/create.blade.php or edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create/Edit User</h1>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <label>Admin:</label>
        <input type="checkbox" name="is_admin" value="1">
        
        <button type="submit">Save</button>
    </form>
@endsection
