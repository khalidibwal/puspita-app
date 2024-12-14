<?php

namespace App\Models\lab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_category_lab';
    protected $primaryKey = 'id'; // Specify the primary key
    public $incrementing = true; // Auto-incrementing primary key
    protected $keyType = 'int'; // Specify the key type as integer
    
    protected $fillable = [
        'category_lab',
    ];
    public function jenisPK()
    {
        return $this->hasMany(jenisPK::class, 'sub_category_lab_id');
    }
}
