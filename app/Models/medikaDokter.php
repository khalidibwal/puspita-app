<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class medikaDokter extends Model
{
    use HasFactory;
    protected $table = 'dokter';
    protected $primaryKey = 'nip';
    protected $fillable = [
        'nip',
        'namaDokter',
        'spesialis',
        'email',
        'noTelp',
        'alamat',
        'fotoDokter',
        'biayaDokter'
    ];
    public $incrementing = false;
}
