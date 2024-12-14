<x-app-layout>
    <h1 class="text-white">Daftar Hasil Lab</h1>

    <a href="{{ route('hasil_lab.create') }}" class="edit-btn mb-4">
        <span class="mr-2">+</span> Tambah Hasil Lab
    </a>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form action="{{ route('hasil_lab.index') }}" method="GET" class="mb-4" style="margin-top: 20px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search" class="form-input" />
        <button type="submit" class="submit-btn">Search</button>
    </form>

    <!-- Display Data Table -->
    <table class="user-table">
        <thead>
            <tr>
                <th>ID Rekam Medis</th>
                <th>Jenis Penyakit</th>
                <th>Hasil</th>
                <th>Penanggung Jawab</th>
                <th>Usia</th>
                <th>Tanggal Hasil</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasilLabs as $hasilLab)
                <tr>
                    <td>{{ $hasilLab->idRekamMedis }}</td>
                    <td>
                        @forelse ($hasilLab->hasilLabJenisPenyakit as $hasilJenis)
                            {{ $hasilJenis->jenisPenyakit ? $hasilJenis->jenisPenyakit->jenisPK : 'N/A' }}<br>
                        @empty
                            No diseases found
                        @endforelse
                    </td>
                    <td>
                        @forelse ($hasilLab->hasilLabJenisPenyakit as $hasilJenis)
                            {{ $hasilJenis->hasil ?? 'N/A' }}<br>
                        @empty
                            No results available
                        @endforelse
                    </td>
                    <td>{{ $hasilLab->penanggung_jawab ?? 'N/A' }}</td>
                    <td>{{ $hasilLab->usia ?? 'N/A' }}</td>
                    <td>{{ $hasilLab->tglHasil ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('hasil_lab.edit', $hasilLab->id) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('hasil_lab.destroy', $hasilLab->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn" onclick="confirmDelete(this)">Delete</button>
                        </form>
                        <a href="{{ route('hasil_lab.show', $hasilLab->id) }}" class="edit-btn">Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        {{ $hasilLabs->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>

    <style>
        /* Basic styles for the table */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .user-table th, .user-table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        .user-table th {
            background-color: white;
            color: #333;
        }
        .user-table tr {
            background-color: white;
            color: #333;
        }
        .user-table tr:nth-child(even) {
            background-color: f1f1f1;
        }
        .user-table tr:hover {
            background-color: #f1f1f1;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        .edit-btn {
            background-color: #4CAF50; /* Green */
            margin-right: 5px;
        }
        .delete-btn {
            background-color: #f44336; /* Red */
        }
        .delete-btn:hover, .edit-btn:hover {
            opacity: 0.8;
        }
        h1 {
            color: white;
        }
        .form-input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
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
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</x-app-layout>
