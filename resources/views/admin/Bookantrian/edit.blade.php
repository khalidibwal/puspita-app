<x-app-layout>
    <h1 class="text-white">Edit Status Book Antrian</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Show general error message --}}
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookantrian.update', $bookantrian->id) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="status" class="block text-white">Status</label>
            <select name="status" class="form-input" required>
                <option value="PENDING" {{ $bookantrian->status === 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="COMPLETED" {{ $bookantrian->status === 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                <option value="CANCELLED" {{ $bookantrian->status === 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                <option value="NOW" {{ $bookantrian->status === 'NOW' ? 'selected' : '' }}>NOW</option>
            </select>

            {{-- Show error for the status field --}}
            @error('status')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">Update Status</button>
        <a href="{{ route('bookantrian.index') }}" class="cancel-btn">Cancel</a>
    </form>

    <style>
        .form-input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .submit-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .cancel-btn {
            margin-left: 10px;
            padding: 10px 20px;
            background-color: #f44336; /* Red */
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</x-app-layout>
