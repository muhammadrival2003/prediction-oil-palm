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
        Schema::create('pemupukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained()->cascadeOnDelete();
            $table->dateTime('tanggal');
            $table->integer('jumlah_pokok');
            $table->decimal('dosis');
            $table->decimal('volume');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemupukans');
    }
};
