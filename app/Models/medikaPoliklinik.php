<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medikaPoliklinik extends Model
{
    use HasFactory;
    protected $table = 'poliklinik';
    protected $primaryKey = 'idPoliklinik'; // Specify the primary key
    public $incrementing = true; // Auto-incrementing primary key
    protected $keyType = 'int'; // Specify the key type as integer
    
    protected $fillable = [
        'namaPoliklinik',
        'gedung'
    ];
}
