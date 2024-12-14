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
        Schema::create('jenis_penyakit', function (Blueprint $table) {
            $table->id(); // ID untuk primary key
            $table->string('jenisPK'); // Kolom untuk jenisPK
            $table->string('nilaiNormal'); // Kolom untuk nilaiNormal
            $table->unsignedBigInteger('sub_category_lab_id'); // Foreign key ke sub_category_lab

            // Menetapkan foreign key dengan kolom id pada tabel sub_category_lab
            $table->foreign('sub_category_lab_id')
                ->references('id') // Merujuk pada kolom id di tabel sub_category_lab
                ->on('sub_category_lab') // Tabel yang dirujuk
                ->onDelete('cascade'); // Opsi untuk menghapus data terkait jika data di sub_category_lab dihapus

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
        Schema::dropIfExists('jenis_penyakit');
    }
};
