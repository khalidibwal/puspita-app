<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Add this line
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ApiUser extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;
    protected $table = 'user_app';
    protected $fillable = [
        'name', 'email', 'password','noBPJS','noTelp','alamat','nik'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bookAntrians()
    {
        return $this->hasMany(BookAntrian::class, 'user_id'); // Define the inverse relationship
    }
}
