<x-app-layout>
    <h1 class="text-white">Detail Hasil Lab</h1>

    <a href="{{ route('hasil_lab.index') }}" class="edit-btn mb-4">
        <span class="mr-2">←</span> Kembali ke Daftar Hasil Lab
    </a>

    <div class="detail-container">
        <h3>Detail Hasil Lab</h3>
        <table class="user-table">
            <tr>
                <th>ID Rekam Medis</th>
                <td>{{ $hasilLab->idRekamMedis }}</td>
            </tr>

            <!-- Display grouped types of penyakit by lab category -->
            @foreach ($groupedByCategory as $category => $hasilJenisList)
                <tr>
                    <th colspan="2">{{ $category }}</th> <!-- Display the category name as header -->
                </tr>
                
                @foreach ($hasilJenisList as $hasilJenis)
                    <tr>
                        <th>{{ $hasilJenis->jenisPenyakit ? $hasilJenis->jenisPenyakit->jenisPK : 'N/A' }}</th>
                        <td>{{ $hasilJenis->hasil ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endforeach

            <!-- Continue with other fields -->
            <tr>
                <th>Penanggung Jawab</th>
                <td>{{ $hasilLab->penanggung_jawab }}</td>
            </tr>
            <tr>
                <th>Usia</th>
                <td>{{ $hasilLab->usia }}</td>
            </tr>
            <tr>
                <th>Tanggal Hasil</th>
                <td>{{ $hasilLab->tglHasil }}</td>
            </tr>
        </table>
        <!-- Button to download PDF -->
        <a href="{{ route('hasil_lab.download_pdf', $hasilLab->id) }}" class="details-btn">
            <span class="mr-2">📄</span> Download PDF
        </a>
    </div>

    <style>
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
        .detail-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .edit-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
        }
        .details-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #2196F3; /* Blue */
            color: white;
            text-decoration: none;
        }
        .details-btn:hover {
            opacity: 0.8;
        }
    </style>
</x-app-layout>
