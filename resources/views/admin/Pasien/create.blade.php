<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <h1 class="text-2xl font-semibold mb-4">Tambah Pasien</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pasiens.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="namaPasien" class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                <input type="text" name="namaPasien" id="namaPasien" class="mt-1 p-2 block w-full border rounded-md" value="{{ old('namaPasien') }}">
            </div>

            <div class="mb-4">
                <label for="NIK" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="NIK" id="NIK" class="mt-1 p-2 block w-full border rounded-md" value="{{ old('NIK') }}">
            </div>

            <div class="mb-4">
                <label for="jenisKelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenisKelamin" id="jenisKelamin" class="mt-1 block w-full border rounded-md p-2">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 block w-full border rounded-md" value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label for="noTelp" class="block text-sm font-medium text-gray-700">No Telp</label>
                <input type="text" name="noTelp" id="noTelp" class="mt-1 p-2 block w-full border rounded-md" value="{{ old('noTelp') }}">
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" class="mt-1 p-2 block w-full border rounded-md">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="noBPJS" class="block text-sm font-medium text-gray-700">No BPJS</label>
                <input type="text" name="noBPJS" id="noBPJS" class="mt-1 p-2 block w-full border rounded-md" value="{{ old('noBPJS') }}">
            </div>

            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" class="mt-1 block w-full border rounded-md p-2">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
        </form>
    </div>
</x-app-layout>
