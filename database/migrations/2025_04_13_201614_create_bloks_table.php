<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bloks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_blok');
            $table->integer('luas_lahan');
            $table->year('tahun_tanam');
            $table->integer('jumlah_pokok');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloks');
    }
};
