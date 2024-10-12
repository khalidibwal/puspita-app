<x-app-layout>
    <h1 class="text-white">Tambah Non-Bookantrian</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('non_bookantrian.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="form-group mb-4">
            <label for="pasien_id" class="text-white">Pilih Pasien:</label>
            <select name="pasien_id" id="pasien_id" required class="form-input">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasiens as $pasien)
                    <option value="{{ $pasien->idPasien }}">{{ $pasien->namaPasien }}</option>
                @endforeach
            </select>
            @error('pasien_id')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="keluhan" class="text-white">Keluhan:</label>
            <input type="text" name="keluhan" id="keluhan" required class="form-input">
            @error('keluhan')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="tanggal_kunjungan" class="text-white">Tanggal Kunjungan:</label>
            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" required class="form-input">
            @error('tanggal_kunjungan')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="status" class="text-white">Status:</label>
            <input type="text" name="status" id="status" class="form-input">
            @error('status')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">Simpan Non-Bookantrian</button>
    </form>

    <a href="{{ route('non_bookantrian.index') }}" class="back-btn">Kembali ke Daftar Non-Bookantrian</a>

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
            background-color: #4CAF50;
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
