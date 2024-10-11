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
        'tanggal_kunjungan',
        'status',
        'user_id', // Foreign key reference to user
    ];

    // Relationship with the User model (assuming user is stored in user_app table)
    public function user()
    {
        return $this->belongsTo(ApiUser::class, 'user_id');
    }
}
