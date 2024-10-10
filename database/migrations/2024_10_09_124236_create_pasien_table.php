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
        Schema::create('pasien', function (Blueprint $table) {
            $table->increments('idPasien');
            // Adding the required fields
            $table->string('namaPasien');
            $table->string('NIK')->unique();
            $table->string('jenisKelamin');
            $table->string('email')->unique();
            $table->string('noTelp');
            $table->text('alamat')->nullable(); // Image field
            $table->string('noBPJS');    
            $table->string('foto')->nullable();    
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
        Schema::dropIfExists('pasien');
    }
};
