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
        Schema::create('userlogin', function (Blueprint $table) {
            $table->bigIncrements('idUser'); // Primary key
            $table->string('fullName'); // Full name
            $table->string('username')->unique(); // Username, unique
            $table->string('password'); // Password (hashed)
            $table->integer('role'); // Role (int)
            $table->integer('active'); // Active (int)
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
        Schema::dropIfExists('userlogin');
    }
};
