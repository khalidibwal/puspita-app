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
        Schema::create('non_bookantrian', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('no_antrian', 20); // Queue number
            $table->string('keluhan'); // Complaint or reason
            $table->date('tanggal_kunjungan'); // Date of the visit
            $table->string('status', 50)->default('PENDING'); // Status of the booking
            // Foreign key reference to pasien table (idPasien)
            $table->unsignedInteger('pasien_id'); // The ID of the patient from pasien table
            $table->foreign('pasien_id')->references('idPasien')->on('pasien')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps(); // Laravel's created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_bookantrian');
    }
};
