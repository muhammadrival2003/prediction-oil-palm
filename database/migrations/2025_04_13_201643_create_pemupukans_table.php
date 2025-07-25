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
            $table->foreignId('jenis_pupuk_id')->constrained('jenis_pupuks')->onDelete('cascade');
            $table->dateTime('tanggal');
            $table->decimal('rencana_dosis')->nullable();
            $table->decimal('rencana_volume')->nullable();
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
