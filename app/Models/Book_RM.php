<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_RM extends Model
{
    use HasFactory;
    // Table name
    protected $table = 'book_rm';
    protected $primaryKey = 'idRekamMedis';
    public $incrementing = false; // Set to false since id is not auto-incrementing
    protected $keyType = 'int'; // Assuming the ID is an integer
    protected $casts = [
        'tglPeriksa' => 'datetime', // Automatically cast to a Carbon instance
    ];

    // Fillable attributes
    protected $fillable = [
        'idRekamMedis', // Include the manual ID
        'dokterNip',
        'poliklinikId',
        'keluhan',
        'diagnosa',
        'terapi',
        'tglPeriksa',
        'userId',
    ];

    // Relationships

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

    // RekamMedis belongs to a User (ApiUser)
    public function userlogin()
    {
        return $this->belongsTo(ApiUser::class, 'userId', 'id'); // Adjust 'id' based on your actual primary key in user_app table
    }
}
