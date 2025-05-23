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
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained()->cascadeOnDelete();
            $table->integer('year');
            $table->integer('month');
            $table->float('rainfall'); // curah_hujan
            $table->float('fertilizer'); // pemupukan
            $table->float('production'); // hasil_produksi
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
