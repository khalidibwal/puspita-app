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
        Schema::create('hasil_lab_jenis_penyakit', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('hasil_lab_id'); // Foreign key to hasil_lab (id as string)
            $table->unsignedBigInteger('jenis_penyakit_id'); // Foreign key to jenis_penyakit (assuming id is unsignedBigInteger)
            $table->string('hasil'); // The result for each disease in the relationship
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('hasil_lab_id')->references('id')->on('hasil_lab')->onDelete('cascade');
            $table->foreign('jenis_penyakit_id')->references('id')->on('jenis_penyakit')->onDelete('cascade');

            // Unique constraint to avoid duplicate entries
            $table->unique(['hasil_lab_id', 'jenis_penyakit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_lab_jenis_penyakit');
    }
};
