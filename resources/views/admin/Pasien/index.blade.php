<x-app-layout>
    <h1 class="text-white">Daftar Pasien</h1>

    <a href="{{ route('pasiens.create') }}" class="edit-btn mb-4">
        <span class="mr-2">+</span> Tambah Pasien
    </a>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="user-table">
        <thead>
            <tr>
                <th>ID Pasien</th>
                <th>Nama Pasien</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>No BPJS</th>
                <th>Foto</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $pasien)
                <tr>
                    <td>{{ $pasien->idPasien }}</td>
                    <td>{{ $pasien->namaPasien }}</td>
                    <td>{{ $pasien->NIK }}</td>
                    <td>{{ $pasien->jenisKelamin }}</td>
                    <td>{{ $pasien->email }}</td>
                    <td>{{ $pasien->noTelp }}</td>
                    <td>{{ $pasien->alamat }}</td>
                    <td>{{ $pasien->noBPJS }}</td>
                    <td>
                        @if ($pasien->foto)
                            <img src="{{ asset('storage/' . $pasien->foto) }}" alt="Foto Pasien" class="w-10 h-10 rounded-full">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pasiens.edit', $pasien->idPasien) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('pasiens.destroy', $pasien->idPasien) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn" onclick="confirmDelete(this)">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
    </style>
</x-app-layout>
