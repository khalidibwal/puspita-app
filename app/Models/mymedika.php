<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class mymedika extends Authenticatable
{
    use HasFactory;
    protected $table = 'userlogin';
    protected $primaryKey = 'idUser';
    protected $fillable = [
        'fullName',
        'username',
        'password',
        'role',
        'active'
    ];
    protected $hidden = [
        'password'
    ];
}
