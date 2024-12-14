<x-app-layout>
    <h1 class="text-white">Tambah Hasil Lab</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('hasil_lab.store') }}" method="POST" class="mb-4" id="hasil-lab-form">
        @csrf

        <!-- Rekam Medis (Dropdown) -->
        <div class="form-group mb-4">
            <label for="idRekamMedis" class="text-white">Rekam Medis:</label>
            <select name="idRekamMedis" id="idRekamMedis" required class="form-input">
                <option value="" disabled selected>Pilih Rekam Medis</option>
                @foreach ($bookRms as $bookRm)
                    <option value="{{ $bookRm->idRekamMedis }}">{{ $bookRm->idRekamMedis }}</option>
                @endforeach
            </select>
            @error('idRekamMedis')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Jenis Penyakit (Dropdown) -->
        <div class="form-group mb-4">
            <label for="jenisPenyakitId" class="text-white">Jenis Penyakit:</label>
            <select name="jenisPenyakitId[]" id="jenisPenyakitId" required class="form-input">
                <option value="" disabled selected>Pilih Jenis Penyakit</option>
                @foreach ($jenisPenyakits as $jenisPenyakit)
                    <option value="{{ $jenisPenyakit->id }}">{{ $jenisPenyakit->jenisPK }}</option>
                @endforeach
            </select>
            @error('jenisPenyakitId')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hasil -->
        <div class="form-group mb-4">
            <label for="hasil" class="text-white">Hasil:</label>
            <input type="text" name="hasil[]" id="hasil" required class="form-input">
            @error('hasil')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Penanggung Jawab -->
        <div class="form-group mb-4">
            <label for="penanggung_jawab" class="text-white">Penanggung Jawab:</label>
            <input type="text" name="penanggung_jawab" id="penanggung_jawab" required class="form-input">
            @error('penanggung_jawab')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Usia -->
        <div class="form-group mb-4">
            <label for="usia" class="text-white">Usia:</label>
            <input type="text" name="usia" id="usia" required class="form-input">
            @error('usia')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tanggal Hasil -->
        <div class="form-group mb-4">
            <label for="tglHasil" class="text-white">Tanggal Hasil:</label>
            <input type="date" name="tglHasil" id="tglHasil" required class="form-input">
            @error('tglHasil')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dynamic Rows -->
        <div id="dynamic-rows"></div>

        <!-- Button to Add New Row -->
        <button type="button" id="addRowBtn" class="submit-btn">Tambah Kolom Baru</button>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Simpan Hasil Lab</button>
    </form>

    <a href="{{ route('hasil_lab.index') }}" class="back-btn">Kembali ke Daftar Hasil Lab</a>

    <script>
        document.getElementById('addRowBtn').addEventListener('click', function() {
            let newRow = document.createElement('div');
            newRow.classList.add('form-group', 'mb-4');
            newRow.innerHTML = `
                <div class="form-group mb-4">
                    <label for="jenisPenyakitId" class="text-white">Jenis Penyakit:</label>
                    <select name="jenisPenyakitId[]" required class="form-input">
                        <option value="" disabled selected>Pilih Jenis Penyakit</option>
                        @foreach ($jenisPenyakits as $jenisPenyakit)
                            <option value="{{ $jenisPenyakit->id }}">{{ $jenisPenyakit->jenisPK }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="hasil" class="text-white">Hasil:</label>
                    <input type="text" name="hasil[]" required class="form-input">
                </div>

                <!-- Delete Button for the row -->
                <button type="button" class="deleteRowBtn text-white bg-red-500 p-2 rounded">Delete</button>
            `;

            // Append the new row to the dynamic rows container
            document.getElementById('dynamic-rows').appendChild(newRow);

            // Add functionality to delete the row
            newRow.querySelector('.deleteRowBtn').addEventListener('click', function() {
                newRow.remove();
            });
        });
    </script>

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

        .text-red-500 {
            color: #f44336;
        }

        .bg-green-500 {
            background-color: #4CAF50;
        }

        .deleteRowBtn {
            margin-top: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .deleteRowBtn:hover {
            background-color: darkred;
        }
    </style>
</x-app-layout>
