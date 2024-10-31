<x-app-layout>
    <h1 class="text-white">Tambah Rekam Medis</h1>

    <!-- Error handling -->
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('book_rm.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="idRekamMedis" class="text-white">ID Rekam Medis</label>
            <input type="text" name="idRekamMedis" id="idRekamMedis" class="input-field" 
                   value="RM{{ now()->format('Ymd') }}{{ str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT) }}" readonly>
            <small class="text-gray-400">Format: RMYYYYMMDDRRRRR (15 characters)</small>
        </div>

        <div class="form-group">
            <label for="pasienId" class="text-white">Pasien</label>
            <select name="pasienId" id="pasienId" class="input-field">
                <option value="">Pilih Pasien</option>
                @foreach($pasien as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="dokterNip" class="text-white">Dokter</label>
            <select name="dokterNip" id="dokterNip" class="input-field">
                <option value="">Pilih Dokter</option>
                @foreach($dokter as $d)
                    <option value="{{ $d->nip }}">{{ $d->namaDokter }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="poliklinikId" class="text-white">Poliklinik</label>
            <select name="poliklinikId" id="poliklinikId" class="input-field">
                <option value="">Pilih Poliklinik</option>
                @foreach($poliklinik as $p)
                    <option value="{{ $p->idPoliklinik }}">{{ $p->namaPoliklinik }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="keluhan" class="text-white">Keluhan</label>
            <input type="text" name="keluhan" id="keluhan" class="input-field" value="{{ old('keluhan') }}">
        </div>

        <div class="form-group">
            <label for="diagnosa" class="text-white">Diagnosa</label>
            <input type="text" name="diagnosa" id="diagnosa" class="input-field" value="{{ old('diagnosa') }}">
        </div>

        <div class="form-group">
            <label for="terapi" class="text-white">Terapi</label>
            <input type="text" name="terapi" id="terapi" class="input-field" value="{{ old('terapi') }}">
        </div>

        <div class="form-group">
            <label for="tglPeriksa" class="text-white">Tanggal Periksa</label>
            <input type="date" name="tglPeriksa" id="tglPeriksa" class="input-field" value="{{ old('tglPeriksa') }}">
        </div>

        <button type="submit" class="submit-btn">Simpan</button>
    </form>

    <style>
        .input-field {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            opacity: 0.8;
        }
    </style>
</x-app-layout>
