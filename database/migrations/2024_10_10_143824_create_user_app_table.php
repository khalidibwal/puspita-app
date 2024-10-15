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
        Schema::create('user_app', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();              // User's Nik
            $table->string('name');              // User's name
            $table->string('email')->unique();   // User's email, must be unique
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');          // User's password (hashed)
            $table->string('noTelp')->nullable(); // User's phone number
            $table->string('noBPJS')->nullable(); // User's BPJS
            $table->string('alamat')->nullable(); // User's address
            $table->boolean('is_admin')->default(0);  // Whether the user is an admin (optional)
            $table->rememberToken();             // Token to remember the user session
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
        Schema::dropIfExists('user_app');
    }
};
