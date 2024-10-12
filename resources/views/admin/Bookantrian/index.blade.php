<x-app-layout>
    <h1 class="text-white">Daftar Book Antrian</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form (if you want to add search functionality) -->
    <form action="{{ route('bookantrian.index') }}" method="GET" class="mb-4" style="margin-top: 20px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Antrian..." class="form-input" />
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
                </tr>
            </thead>
            <tbody>
                @foreach ($bookantrians as $bookantrian)
                    <tr>
                        <td>{{ $bookantrian->no_antrian }}</td>
                        <td>{{ $bookantrian->keluhan }}</td>
                        <td>{{ $bookantrian->tanggal_kunjungan }}</td>
                        <td>{{ $bookantrian->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Include SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Show the popup when the page loads
        $(document).ready(function() {
            Swal.fire({
                title: 'Tunggu 5 detik',
                text: 'Data antrian untuk Refresh',
                icon: 'info',
                timer: 5000,  // 5 seconds timer
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

        // Auto-reload data every 5 seconds
        setInterval(fetchLatestData, 5000);

        function fetchLatestData() {
            $.ajax({
                url: '/bookantrian/latest', // The route you created to get the latest data
                method: 'GET',
                success: function(data) {
                    updateTable(data);
                }
            });
        }

        // Function to update the table with the new data
        function updateTable(bookantrians) {
            let tableBody = $('#bookantrian-table tbody');
            tableBody.empty(); // Clear the existing table body

            bookantrians.forEach(function(bookantrian) {
                let row = `
                    <tr>
                        <td>${bookantrian.no_antrian}</td>
                        <td>${bookantrian.keluhan}</td>
                        <td>${bookantrian.tanggal_kunjungan}</td>
                        <td>${bookantrian.status}</td>
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

        /* Scrollable table container */
        .table-container {
            max-height: 400px; /* Set a fixed height */
            overflow-y: auto; /* Enable vertical scroll */
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
