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
        Schema::create('bookantrian', function (Blueprint $table) {
            $table->id();
            $table->string('no_antrian', 20);               // Queue number
            $table->string('keluhan');
            $table->date('tanggal_kunjungan');              // Date of the visit
            $table->string('status', 50)->default('PENDING'); // Status of the booking
             // Foreign key reference to user_app table (userId)
             $table->unsignedBigInteger('user_id');  // The ID of the logged-in user
             $table->foreign('user_id')->references('id')->on('user_app')->onDelete('cascade');
             $table->unsignedInteger('poliklinikId');
            $table->foreign('poliklinikId')->references('idPoliklinik')->on('poliklinik')->onDelete('cascade');
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
        Schema::dropIfExists('bookantrian');
    }
};
