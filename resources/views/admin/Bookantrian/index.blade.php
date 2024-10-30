<x-app-layout>
    <h1 class="text-white">Daftar Book Antrian</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form action="{{ route('bookantrian.index') }}" method="GET" class="mb-4 search-form">
        <!-- <label for="search" class="text-white">Search Status:</label> -->
        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search Status..." class="form-input" />
        <button type="submit" class="submit-btn">Search</button>
    </form>

    <div class="table-container">
        <table class="user-table" id="bookantrian-table">
            <thead>
                <tr>
                    <th>No Antrian</th>
                    <th>Keluhan</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Status</th>
                    <th>Poliklinik</th>
                    <th>Pasien Booking</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookantrians as $bookantrian)
                    <tr>
                        <td>{{ $bookantrian->no_antrian }}</td>
                        <td>{{ $bookantrian->keluhan }}</td>
                        <td>{{ $bookantrian->tanggal_kunjungan }}</td>
                        <td>{{ $bookantrian->status }}</td>
                        <td>{{ $bookantrian->poliklinik->namaPoliklinik ?? 'N/A' }}</td>
                        <td>{{ $bookantrian->user->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('bookantrian.edit', $bookantrian->id) }}" class="edit-btn">Edit</a>
                            <form action="{{ route('bookantrian.destroy', $bookantrian->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-btn" onclick="confirmDelete(this)">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Include SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Tunggu 5 detik',
                text: 'Data antrian untuk Refresh',
                icon: 'info',
                timer: 5000,
                showConfirmButton: false
            });
        });

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

        setInterval(fetchLatestData, 5000);

        let currentData = [];

function fetchLatestData() {
    $.ajax({
        url: '/bookantrian/latest',
        method: 'GET',
        success: function(data) {
            console.log(data); // Check the new data

            // Check if there are changes
            if (JSON.stringify(data) !== JSON.stringify(currentData)) {
                currentData = data; // Update current data
                updateTable(data);   // Update the table
            }
        }
    });
}


        function updateTable(bookantrians) {
            let tableBody = $('#bookantrian-table tbody');
            tableBody.empty();

            bookantrians.forEach(function(bookantrian) {
                let row = `
                    <tr>
                        <td>${bookantrian.no_antrian}</td>
                        <td>${bookantrian.keluhan}</td>
                        <td>${bookantrian.tanggal_kunjungan}</td>
                        <td>${bookantrian.status}</td>
                        <td>${bookantrian.poliklinik ? bookantrian.poliklinik.namaPoliklinik : 'N/A'}</td>
                        <td>${bookantrian.user ? bookantrian.user.name : 'N/A'}</td>
                        <td>
                            <a href="/admin/bookantrian/${bookantrian.id}/edit" class="edit-btn">Edit</a>
                            <form action="/admin/bookantrian/${bookantrian.id}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-btn" onclick="confirmDelete(this)">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
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
        .table-container {
            max-height: 400px; 
            overflow-y: auto; 
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
            background-color: #4CAF50; 
            margin-right: 5px;
        }
        .delete-btn {
            background-color: #f44336; 
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
            background-color: #4CAF50; 
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
