<x-app-layout>
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-10">
        <div class="p-6">
            <h1 class="text-xl font-semibold mb-4">Edit Pasien</h1>
            <form action="{{ route('pasiens.update', $pasien->idPasien) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Pasien -->
                <div class="mb-4">
                    <label for="namaPasien" class="block text-sm font-medium text-gray-700">Nama Pasien:</label>
                    <input type="text" name="namaPasien" id="namaPasien" 
                           value="{{ old('namaPasien', $pasien->namaPasien) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('namaPasien')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIK -->
                <div class="mb-4">
                    <label for="NIK" class="block text-sm font-medium text-gray-700">NIK:</label>
                    <input type="text" name="NIK" id="NIK" 
                           value="{{ old('NIK', $pasien->NIK) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('NIK')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-4">
                    <label for="jenisKelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin:</label>
                    <select name="jenisKelamin" id="jenisKelamin" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                        <option value="Laki-laki" {{ $pasien->jenisKelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $pasien->jenisKelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenisKelamin')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', $pasien->email) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- No Telp -->
                <div class="mb-4">
                    <label for="noTelp" class="block text-sm font-medium text-gray-700">No Telp:</label>
                    <input type="text" name="noTelp" id="noTelp" 
                           value="{{ old('noTelp', $pasien->noTelp) }}" 
                           required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('noTelp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat:</label>
                    <textarea name="alamat" id="alamat" rows="3" required 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">{{ old('alamat', $pasien->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- No BPJS -->
                <div class="mb-4">
                    <label for="noBPJS" class="block text-sm font-medium text-gray-700">No BPJS:</label>
                    <input type="text" name="noBPJS" id="noBPJS" 
                           value="{{ old('noBPJS', $pasien->noBPJS) }}" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('noBPJS')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Foto -->
                <div class="mb-4">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Upload Foto:</label>
                    <input type="file" name="foto" id="foto" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300 p-2">
                    @error('foto')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-500 transition">Update Pasien</button>

            </form>
        </div>
    </div>
</x-app-layout>
