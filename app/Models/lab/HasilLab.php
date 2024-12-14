<?php

namespace App\Models\lab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Book_RM; // Add this line to import Book_RM model
use Illuminate\Database\Eloquent\Model;

class HasilLab extends Model
{
    use HasFactory;
     // Tentukan nama tabel jika tidak sesuai dengan konvensi plural
     protected $table = 'hasil_lab';

     // Tentukan kolom yang bisa diisi (mass assignment)
     protected $fillable = [
         'id', 'idRekamMedis', 'penanggung_jawab', 'usia', 'tglHasil'
     ];
 
     // Relasi ke model Book_RM
    public function bookRm()
    {
        return $this->belongsTo(Book_RM::class, 'idRekamMedis', 'idRekamMedis');
    }

    // Relasi ke model JenisPK
    public function jenisPenyakit()
    {
        return $this->belongsTo(jenisPK::class, 'jenisPenyakitId', 'id');
    }
    public function jenisPenyakits()
    {
        return $this->belongsToMany(jenisPK::class, 'hasil_lab_jenis_penyakit', 'hasil_lab_id', 'jenis_penyakit_id')
                    ->withPivot('hasil') // Menyertakan kolom 'hasil' dari pivot table
                    ->withTimestamps();
    }
    public function hasilLabJenisPenyakit()
{
    return $this->hasMany(HasilLabJenisPenyakit::class, 'hasil_lab_id'); // Assuming 'hasil_lab_id' is the foreign key
}
}
