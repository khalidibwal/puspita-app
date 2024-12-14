<?php

namespace App\Models\lab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilLabJenisPenyakit extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'hasil_lab_jenis_penyakit';

    // Tentukan kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'hasil_lab_id', 'jenis_penyakit_id', 'hasil'
    ];

    // Relasi ke HasilLab
    public function hasilLab()
    {
        return $this->belongsTo(HasilLab::class, 'hasil_lab_id');
    }

    // Relasi ke JenisPenyakit
    public function jenisPenyakit()
    {
        return $this->belongsTo(jenisPK::class, 'jenis_penyakit_id','id');
    }
    public static function groupByCategory($hasilLab)
    {
        return $hasilLab->hasilLabJenisPenyakit->groupBy(function($hasilJenis) {
            return $hasilJenis->jenisPenyakit->labCategory->category_lab;
        });
    }
}
