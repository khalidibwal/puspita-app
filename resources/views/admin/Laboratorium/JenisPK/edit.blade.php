<x-app-layout>
    <h1 class="text-white">Edit Lab Test</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('jenis_pemeriksaan.update', ['jenis_pemeriksaan' => $jenisPK->id]) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT') <!-- Specifies this form is for updating an existing record -->
    
        <!-- Jenis PK -->
        <div class="form-group mb-4">
            <label for="jenisPK" class="text-white">Jenis PK:</label>
            <input type="text" name="jenisPK" id="jenisPK" value="{{ old('jenisPK', $jenisPK->jenisPK) }}" required class="form-input">
            @error('jenisPK')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Nilai Normal -->
        <div class="form-group mb-4">
            <label for="nilaiNormal" class="text-white">Nilai Normal:</label>
            <input type="text" name="nilaiNormal" id="nilaiNormal" value="{{ old('nilaiNormal', $jenisPK->nilaiNormal) }}" required class="form-input">
            @error('nilaiNormal')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Category Lab (Dropdown) -->
        <div class="form-group mb-4">
            <label for="sub_category_lab_id" class="text-white">Category Lab:</label>
            <select name="sub_category_lab_id" id="sub_category_lab_id" required class="form-input">
                <option value="" disabled selected>Pilih Category Lab</option>
                @foreach ($labCategory as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $jenisPK->sub_category_lab_id ? 'selected' : '' }}>
                        {{ $category->category_lab }}
                    </option>
                @endforeach
            </select>
            @error('sub_category_lab_id')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="submit-btn">Update Jenis Pemeriksaan</button>
    </form>
    

    <a href="{{ route('jenis_pemeriksaan.index') }}" class="back-btn">Kembali ke Daftar Jenis Pemeriksaan</a>

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

        .text-red-500 {
            color: #f44336;
        }

        .bg-green-500 {
            background-color: #4CAF50;
        }
    </style>
</x-app-layout>
