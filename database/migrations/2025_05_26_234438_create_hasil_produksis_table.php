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
        Schema::create('hasil_produksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blok_id');
            $table->dateTime('tanggal');
            $table->integer('rencana_produksi')->default(0);
            $table->integer('realisasi_produksi')->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('blok_id')
                  ->references('id')
                  ->on('bloks')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_produksis');
    }
};