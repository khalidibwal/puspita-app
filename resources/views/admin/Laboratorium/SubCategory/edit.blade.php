<x-app-layout>
    <h1 class="text-white">Edit Lab Category</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('category_lab.update', $sub_category->id) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT') <!-- This specifies that the form is a PUT request for update -->

        <div class="form-group mb-4">
            <label for="namaObat" class="text-white">Category Lab:</label>
            <input type="text" name="category_lab" id="namaObat" value="{{ old('category_lab', $sub_category->category_lab) }}" required class="form-input">
            @error('category_lab')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">Update Category Lab</button>
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
