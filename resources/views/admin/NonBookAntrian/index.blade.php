<x-app-layout>
    <h1 class="text-white">Daftar Non-Book Antrian</h1>

    <a href="{{ route('non_bookantrian.create') }}" class="edit-btn mb-4">
        <span class="mr-2">+</span> Tambah Non-Book Antrian
    </a>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="user-table">
        <thead>
            <tr>
                <th>ID Antrian</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th>Tanggal Kunjungan</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nonBookAntrians as $nonBookAntrian)
                <tr>
                    <td>{{ $nonBookAntrian->no_antrian }}</td>
                    <td class="border px-4 py-2">
                        <!-- Find the corresponding Pasien by pasien_id -->
                        @foreach ($pasiens as $pasien)
                            @if ($pasien->idPasien == $nonBookAntrian->pasien_id)
                                {{ $pasien->namaPasien }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $nonBookAntrian->keluhan }}</td>
                    <td>{{ \Carbon\Carbon::parse($nonBookAntrian->tanggal_kunjungan)->format('d-m-Y') }}</td>
                    
                    <td>{{ $nonBookAntrian->status }}</td>
                    <td>
                        <a href="{{ route('non_bookantrian.edit', $nonBookAntrian->id) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('non_bookantrian.destroy', $nonBookAntrian->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn" onclick="confirmDelete(this)">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

        <!-- Pagination Links -->
        <div class="pagination">
        {{ $nonBookAntrians->links() }} <!-- This will generate the pagination links -->
    </div>

    <!-- Include SweetAlert2 CDN -->
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
                    // If confirmed, submit the form
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
            background-color: grey;
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
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</x-app-layout>
