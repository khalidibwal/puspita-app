<x-app-layout>
    <h1 class="text-white">Edit Rekam Medis</h1>

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

    <form action="{{ route('rekammedis.update', $rekamMedis->idRekamMedis) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden input for userId -->
        <input type="hidden" name="userId" value="{{ auth()->id() }}">

        <div class="form-group">
            <label for="pasienId" class="text-white">Pasien</label>
            <select name="pasienId" id="pasienId" class="input-field">
                @foreach($pasien as $p)
                    <option value="{{ $p->idPasien }}" {{ $rekamMedis->pasienId == $p->idPasien ? 'selected' : '' }}>{{ $p->namaPasien }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="dokterNip" class="text-white">Dokter</label>
            <select name="dokterNip" id="dokterNip" class="input-field">
                @foreach($dokter as $d)
                    <option value="{{ $d->nip }}" {{ $rekamMedis->dokterNip == $d->nip ? 'selected' : '' }}>{{ $d->namaDokter }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="poliklinikId" class="text-white">Poliklinik</label>
            <select name="poliklinikId" id="poliklinikId" class="input-field">
                @foreach($poliklinik as $p)
                    <option value="{{ $p->idPoliklinik }}" {{ $rekamMedis->poliklinikId == $p->idPoliklinik ? 'selected' : '' }}>{{ $p->namaPoliklinik }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="keluhan" class="text-white">Keluhan</label>
            <input type="text" name="keluhan" id="keluhan" class="input-field" value="{{ $rekamMedis->keluhan }}">
        </div>

        <div class="form-group">
            <label for="diagnosa" class="text-white">Diagnosa</label>
            <input type="text" name="diagnosa" id="diagnosa" class="input-field" value="{{ $rekamMedis->diagnosa }}">
        </div>

        <div class="form-group">
            <label for="terapi" class="text-white">Terapi</label>
            <input type="text" name="terapi" id="terapi" class="input-field" value="{{ $rekamMedis->terapi }}">
        </div>

        <div class="form-group">
            <label for="tglPeriksa" class="text-white">Tanggal Periksa</label>
            <input type="date" name="tglPeriksa" id="tglPeriksa" class="input-field" value="{{ $rekamMedis->tglPeriksa->format('Y-m-d') }}">
        </div>

        <button type="submit" class="submit-btn">Update</button>
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
