<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->increments('idRekamMedis'); // Incremental ID

            // Foreign key to 'pasien' table
            $table->unsignedInteger('pasienId');
            $table->foreign('pasienId')->references('idPasien')->on('pasien')->onDelete('cascade');

            // Foreign key to 'dokter' table
            $table->string('dokterNip');
            $table->foreign('dokterNip')->references('nip')->on('dokter')->onDelete('cascade');

            // Foreign key to 'poliklinik' table
            $table->unsignedInteger('poliklinikId');
            $table->foreign('poliklinikId')->references('idPoliklinik')->on('poliklinik')->onDelete('cascade');

            // Foreign key to 'userlogin' table
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('idUser')->on('userlogin')->onDelete('cascade');

            // Other columns
            $table->string('keluhan');
            $table->string('diagnosa');
            $table->string('terapi');
            $table->date('tglPeriksa');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekam_medis');
    }
}
