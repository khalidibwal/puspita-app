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
        Schema::create('book_rm', function (Blueprint $table) {
            $table->string('idRekamMedis', 15)->primary();

            // Foreign key to 'dokter' table
            $table->string('dokterNip');
            $table->foreign('dokterNip')->references('nip')->on('dokter')->onDelete('cascade');

            // Foreign key to 'poliklinik' table
            $table->unsignedInteger('poliklinikId');
            $table->foreign('poliklinikId')->references('idPoliklinik')->on('poliklinik')->onDelete('cascade');

            // Foreign key to 'user_app' table
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('user_app')->onDelete('cascade'); // Change to user_app

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
        Schema::dropIfExists('book_rm');
    }
};
