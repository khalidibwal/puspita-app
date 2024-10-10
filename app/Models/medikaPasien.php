<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medikaPasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';
    protected $primaryKey = 'idPasien'; // Specify the primary key
    public $incrementing = true; // Auto-incrementing primary key
    protected $keyType = 'int'; // Specify the key type as integer
    
    protected $fillable = [
        'namaPasien',
        'NIK',
        'jenisKelamin',
        'email',
        'noTelp',
        'alamat',
        'noBPJS',
        'foto'
    ];
}
