<x-app-layout>
    <h1 class="text-white">Tambah Obat</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('obats.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="form-group mb-4">
            <label for="namaObat" class="text-white">Nama Obat:</label>
            <input type="text" name="namaObat" id="namaObat" required class="form-input">
            @error('namaObat')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- <div class="form-group mb-4">
            <label for="harga" class="text-white">Harga:</label>
            <input type="number" name="harga" id="harga" required class="form-input">
            @error('harga')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div> -->

        <div class="form-group mb-4">
            <label for="stok" class="text-white">Stok:</label>
            <input type="number" name="stok" id="stok" required class="form-input">
            @error('stok')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="keterangan" class="text-white">Keterangan:</label>
            <textarea name="keterangan" id="keterangan" rows="4" class="form-input"></textarea>
            @error('keterangan')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">Simpan Obat</button>
    </form>

    <a href="{{ route('obats.index') }}" class="back-btn">Kembali ke Daftar Obat</a>

    <style>
        h1 {
            color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
        }

        .form-input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .submit-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            display: inline-block;
            margin-top: 1rem;
            color: #4CAF50;
            text-decoration: underline;
        }

        .back-btn:hover {
            color: #45a049;
        }
    </style>
</x-app-layout>
