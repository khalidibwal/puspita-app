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
        Schema::create('dokter', function (Blueprint $table) {
            // Changing the primary key to 'nip'
            $table->string('nip')->primary(); 
            // Adding the required fields
            $table->string('namaDokter');
            $table->string('spesialis');
            $table->string('email')->unique();
            $table->string('noTelp');
            $table->text('alamat');
            $table->string('fotoDokter')->nullable(); // Image field
            $table->integer('biayaDokter'); // Integer field for doctor's fee       
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
        Schema::dropIfExists('dokter');
    }
};
