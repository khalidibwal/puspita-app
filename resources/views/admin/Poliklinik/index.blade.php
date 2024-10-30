<x-app-layout>
    <h1 class="text-white">Daftar Poliklinik</h1>

    <a href="{{ route('polikliniks.create') }}" class="edit-btn mb-4">
        <span class="mr-2">+</span> Tambah Poliklinik
    </a>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

        <!-- Search Form -->
        <form action="{{ route('polikliniks.index') }}" method="GET" class="mb-4" style="margin-top: 20px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Poliklinik..." class="form-input" />
        <button type="submit" class="submit-btn">Search</button>
    </form>

    <table class="user-table">
        <thead>
            <tr>
                <th>ID Poliklinik</th>
                <th>Nama Poliklinik</th>
                <th>Gedung</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($polikliniks as $poliklinik)
                <tr>
                    <td>{{ $poliklinik->idPoliklinik }}</td>
                    <td>{{ $poliklinik->namaPoliklinik }}</td>
                    <td>{{ $poliklinik->gedung }}</td>
                    <td>
                        <a href="{{ route('polikliniks.edit', $poliklinik->idPoliklinik) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('polikliniks.destroy', $poliklinik->idPoliklinik) }}" method="POST" style="display:inline;" class="delete-form">
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
        {{ $polikliniks->links() }} <!-- This will generate the pagination links -->
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
