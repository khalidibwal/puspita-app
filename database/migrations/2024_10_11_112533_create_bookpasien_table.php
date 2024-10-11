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
        Schema::create('bookpasien', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->string('namaPasien');  // Name of the patient
            $table->string('NIK')->unique();  // Unique National Identification Number
            $table->string('jenisKelamin');  // Gender of the patient
            $table->string('noTelp');  // Patient's phone number
            $table->text('alamat')->nullable();  // Address (optional)
            $table->string('noBPJS')->nullable();  // BPJS number (health insurance)
            $table->string('foto')->nullable();  // Photo (optional)

            // Foreign key reference to user_app table (userId)
            $table->unsignedBigInteger('user_id');  // The ID of the logged-in user
            $table->foreign('user_id')->references('id')->on('user_app')->onDelete('cascade');

            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookpasien');
    }
};
