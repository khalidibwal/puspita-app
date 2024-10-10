<x-app-layout>
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-10">
        <div class="p-6">
            <h1 class="text-xl font-semibold mb-4">Edit Dokter</h1>
            <form action="{{ route('dokters.update', $dokter->nip) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium text-gray-700">NIP:</label>
                    <input type="text" name="nip" id="nip" 
                           value="{{ old('nip', $dokter->nip) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('nip')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="namaDokter" class="block text-sm font-medium text-gray-700">Nama Dokter:</label>
                    <input type="text" name="namaDokter" id="namaDokter" 
                           value="{{ old('namaDokter', $dokter->namaDokter) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('namaDokter')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="spesialis" class="block text-sm font-medium text-gray-700">Spesialis:</label>
                    <input type="text" name="spesialis" id="spesialis" 
                           value="{{ old('spesialis', $dokter->spesialis) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('spesialis')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', $dokter->email) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="noTelp" class="block text-sm font-medium text-gray-700">No Telp:</label>
                    <input type="text" name="noTelp" id="noTelp" 
                           value="{{ old('noTelp', $dokter->noTelp) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('noTelp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat:</label>
                    <textarea name="alamat" id="alamat" 
                              required 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">{{ old('alamat', $dokter->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="fotoDokter" class="block text-sm font-medium text-gray-700">Foto Dokter:</label>
                    <input type="file" name="fotoDokter" id="fotoDokter" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('fotoDokter')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="biayaDokter" class="block text-sm font-medium text-gray-700">Biaya Dokter:</label>
                    <input type="number" name="biayaDokter" id="biayaDokter" 
                           value="{{ old('biayaDokter', $dokter->biayaDokter) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('biayaDokter')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-500 transition">Update Dokter</button>
            </form>
        </div>
    </div>
</x-app-layout>
