<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Add this line
use Illuminate\Foundation\Auth\User as Authenticatable;

class BookPasien extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;
    protected $table = 'bookpasien';
    protected $fillable = [
        'namaPasien',
        'NIK',
        'jenisKelamin',
        'noTelp',
        'alamat',
        'noBPJS',
        'foto',
        'user_id',  // Allow mass assignment of user_id
    ];
    public function user()
    {
        return $this->belongsTo(ApiUser::class, 'user_id');
    }
}
