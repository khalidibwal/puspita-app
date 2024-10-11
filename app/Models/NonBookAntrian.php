<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonBookAntrian extends Model
{
    use HasFactory;
    // Specify the table associated with the model
    protected $table = 'non_bookantrian';

    // The attributes that are mass assignable
    protected $fillable = [
        'no_antrian',
        'keluhan',
        'tanggal_kunjungan',
        'status',
        'user_id',
    ];

    // Define the relationship with the UserLogin model
    public function user()
    {
        return $this->belongsTo(UserLogin::class, 'user_id', 'idUser');
    }
}
