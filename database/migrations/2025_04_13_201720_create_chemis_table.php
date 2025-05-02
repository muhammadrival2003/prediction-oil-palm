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
        Schema::create('chemis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->float('rencana_chemis');
            $table->float('realisasi_chemis')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chemis');
    }
};
