<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'rekam_medis';
    protected $primaryKey = 'idRekamMedis';
    protected $casts = [
        'tglPeriksa' => 'datetime', // This will automatically cast 'tglPeriksa' to a Carbon instance
    ];

    // Fillable attributes
    protected $fillable = [
        'pasienId',
        'dokterNip',
        'poliklinikId',
        'keluhan',
        'diagnosa',
        'terapi',
        'tglPeriksa',
        'userId'
    ];

    // Relationships

    // RekamMedis belongs to a Pasien
    public function pasien()
    {
        return $this->belongsTo(medikaPasien::class, 'pasienId', 'idPasien');
    }

    // RekamMedis belongs to a Dokter
    public function dokter()
    {
        return $this->belongsTo(medikaDokter::class, 'dokterNip', 'nip');
    }

    // RekamMedis belongs to a Poliklinik
    public function poliklinik()
    {
        return $this->belongsTo(medikaPoliklinik::class, 'poliklinikId', 'idPoliklinik');
    }

    // RekamMedis belongs to a User
    public function userlogin()
    {
        return $this->belongsTo(mymedika::class, 'userId', 'idUser');
    }
}
