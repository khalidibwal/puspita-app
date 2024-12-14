<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_lab', function (Blueprint $table) {
            // Ubah id menjadi string dan tentukan panjangnya
            $table->id();

            // Foreign key ke tabel book_rm
            $table->string('idRekamMedis'); // Kolom untuk menyimpan idRekamMedis dari tabel book_rm
            $table->foreign('idRekamMedis')
                ->references('idRekamMedis')
                ->on('book_rm')
                ->onDelete('cascade'); // Jika data di book_rm dihapus, data ini juga akan dihapu
            $table->string('penanggung_jawab');
            $table->string('usia');

            // Tanggal pemeriksaan
            $table->date('tglHasil'); // Menyimpan tanggal hasil laboratorium

            // Timestamps
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_lab');
    }
};
