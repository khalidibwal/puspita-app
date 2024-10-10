<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medikaObat extends Model
{
    use HasFactory;
    protected $table = 'obat';
    protected $primaryKey = 'idObat'; // Specify the primary key
    public $incrementing = true; // Auto-incrementing primary key
    protected $keyType = 'int'; // Specify the key type as integer
    
    protected $fillable = [
        'namaObat',
        'harga',
        'stok',
        'keterangan',
    ];
}
