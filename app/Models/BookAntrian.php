<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAntrian extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'bookantrian';

    // Fillable fields for mass assignment
    protected $fillable = [
        'no_antrian',
        'keluhan',
        'alergi',
        'waktu_kunjungan',
        'tanggal_kunjungan',
        'status',
        'user_id',       // Foreign key reference to user
        'poliklinikId',  // Foreign key reference to poliklinik
        'dokterNip',  // Foreign key reference to poliklinik
    ];

    // Relationship with the User model (assuming user is stored in user_app table)
    public function user()
    {
        return $this->belongsTo(ApiUser::class, 'user_id');
    }

    // Relationship with the Poliklinik model
    public function poliklinik()
    {
        return $this->belongsTo(medikaPoliklinik::class, 'poliklinikId', 'idPoliklinik');
    }
    // Relationship with the dokter model
    public function dokter()
    {
        return $this->belongsTo(medikaDokter::class, 'dokterNip', 'nip');
    }
}
