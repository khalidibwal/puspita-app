<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Hasil Lab</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            background-color: #37a533;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 0;
            font-size: 30px;
            letter-spacing: 1px;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin: 30px 0;
            background-color: #ffffff;
            border-collapse: collapse;
            table-layout: fixed;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            font-weight: 600;
            background-color: #e9ecef;
            color: #333;
        }

        td {
            font-size: 15px;
            color: #555;
        }

        /* Exam Header */
        .exam-header {
            background-color: #37a533;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        /* Category Row Style */
        .category-row {
            background-color: #e2f7e1; /* Light green for category */
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        /* Clinic Information */
        .header-info {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .header-info div {
            flex: 1;
            text-align: center;
        }

        .clinic-info h2 {
            font-size: 22px;
            font-weight: 600;
            color: #37a533;
            margin: 0;
        }

        .clinic-info p {
            font-size: 14px;
            margin: 5px 0;
            color: #555;
        }

        /* Small spacing for the footer and headers */
        .footer {
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
            font-size: 12px;
            margin-top: 30px;
        }

        /* Title styling */
        .main-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<!-- Main Title -->
<div class="main-title">
    <h1>Hasil Pemeriksaan Laboratorium</h1>
</div>

<!-- Header Section -->
<div class="header-info">
    <div class="clinic-info">
        <h2>Klinik Puspita Medika</h2>
        <p>Jl. Raya Tapos No. 41 Rt 03 Rw 03 Tapos - Kota Depok</p>
        <p>Whatsapp: 087883219690 | Email: puspitamedika23@gmail.com</p>
    </div>
</div>

<!-- Patient Information Table -->
<table>
    <thead>
        <tr>
            <th style="width: 25%;">No Lab</th>
            <td>{{ $hasilLab->id }}</td>
            <th style="width: 25%;">No RM</th>
            <td>{{ $hasilLab->idRekamMedis }}</td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $hasilLab->bookRm->userlogin->name }}</td>
            <th>Usia/Tgl.Lahir</th>
            <td>{{ $hasilLab->usia }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $hasilLab->bookRm->userlogin->alamat }}</td>
            <th>Dokter Pengirim</th>
            <td>{{ $hasilLab->bookRm->dokter->namaDokter }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $hasilLab->tglHasil }}</td>
            <th>Kategori Pasien</th>
            <td>Umum</td>
        </tr>
    </thead>
</table>

<!-- Exam Header Table -->
<table>
    <thead>
        <tr class="exam-header">
            <th style="width: 25%;">Pemeriksaan</th>
            <th style="width: 35%;">Hasil Pemeriksaan</th>
            <th style="width: 35%;">Nilai Normal</th>
        </tr>
    </thead>
</table>

<!-- Results Table -->
<table>
    <tbody>
        @foreach ($groupedByCategory as $category => $hasilJenisList)
            <!-- Category Header Row -->
            <tr class="category-row">
                <td colspan="3">{{ $category }}</td>
            </tr>
            
            <!-- Data Rows for Each HasilJenis -->
            @foreach ($hasilJenisList as $hasilJenis)
                <tr>
                    <td>- {{ $hasilJenis->jenisPenyakit ? $hasilJenis->jenisPenyakit->jenisPK : 'N/A' }}</td>
                    <td>{{ $hasilJenis->hasil ?? 'N/A' }}</td>
                    <td>{{ $hasilJenis->jenisPenyakit ? $hasilJenis->jenisPenyakit->nilaiNormal : 'N/A' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<!-- Footer Section -->
<div class="footer">
    <p>&copy; 2024 Klinik Puspita Medika. All rights reserved.</p>
</div>

</body>
</html>
