<?php

namespace App\Models\lab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisPK extends Model
{
    use HasFactory;
    protected $table = 'jenis_penyakit';
    protected $primaryKey = 'id'; // Specify the primary key
    public $incrementing = true; // Auto-incrementing primary key
    protected $keyType = 'int'; // Specify the key type as integer
    
    protected $fillable = [
        'jenisPK',
        'nilaiNormal',
        'sub_category_lab_id',
    ];
    public function labCategory()
    {
        return $this->belongsTo(labCategory::class, 'sub_category_lab_id');
    }
    public function hasilLabs()
{
    return $this->belongsToMany(HasilLab::class, 'hasil_lab_jenis_penyakit', 'jenis_penyakit_id', 'hasil_lab_id')
                ->withPivot('hasil') // Untuk mengambil kolom 'hasil' dari pivot
                ->withTimestamps();
}
public function hasilLabJenisPenyakits()
{
    return $this->hasMany(HasilLabJenisPenyakit::class, 'jenisPenyakitId');
}

}
