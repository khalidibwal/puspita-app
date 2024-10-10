<x-app-layout>
    <h1 class="text-white">Tambah Poliklinik</h1>

    <form action="{{ route('polikliniks.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="namaPoliklinik" class="block text-white">Nama Poliklinik</label>
            <input type="text" name="namaPoliklinik" id="namaPoliklinik" required
                class="w-full rounded border-gray-300 p-2" placeholder="Masukkan Nama Poliklinik">
        </div>

        <div class="mb-4">
            <label for="gedung" class="block text-white">Gedung</label>
            <input type="text" name="gedung" id="gedung" required
                class="w-full rounded border-gray-300 p-2" placeholder="Masukkan Nama Gedung">
        </div>

        <button type="submit" class="edit-btn">Simpan Poliklinik</button>
        <a href="{{ route('polikliniks.index') }}" class="cancel-btn">Batal</a>
    </form>

    <style>
        .edit-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            text-decoration: none;
        }
        .cancel-btn {
            background-color: #f44336; /* Red */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .edit-btn:hover, .cancel-btn:hover {
            opacity: 0.8;
        }
    </style>
</x-app-layout>
