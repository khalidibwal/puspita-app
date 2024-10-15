<!-- resources/views/admin/edit.blade.php -->
<x-app-layout>
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-10">
        <div class="p-6">
            <h1 class="text-xl font-semibold mb-4">Edit User</h1>
            <form action="{{ route('users.update', $user->idUser) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Full Name -->
                <div class="mb-4">
                    <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name:</label>
                    <input type="text" name="fullName" id="fullName" 
                           value="{{ old('fullName', $user->fullName) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('fullName')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                    <input type="text" name="username" id="username" 
                           value="{{ old('username', $user->username) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('username')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep current password):</label>
                    <input type="password" name="password" id="password" minlength="6"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
                    <select name="role" id="role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Active -->
                <div class="mb-4 flex items-center">
                    <label for="active" class="text-sm font-medium text-gray-700">Active?</label>
                    <input type="checkbox" name="active" id="active" value="1" {{ $user->active ? 'checked' : '' }} class="mr-2">
                </div>

                <button type="submit" class="w-full bg-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-500 transition">Update User</button>

            </form>
        </div>
    </div>
</x-app-layout>
