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
        Schema::create('many_gawangan_manuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('rencana_gawangan');
            $table->integer('realisasi_gawangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('many_gawangan_manuals');
    }
};
