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
        Schema::create('dataset_sistems', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('month'); // 1-12 untuk Jan-Dec
            $table->unsignedSmallInteger('year'); // format 4 digit tahun
            $table->decimal('total_curah_hujan', 8, 2)->nullable();
            $table->decimal('total_pemupukan', 8, 2)->nullable();
            $table->decimal('total_hasil_produksi', 8, 2)->nullable();
            $table->timestamps();
            
            // Optional: tambahkan index untuk bulan dan tahun jika sering di-query
            $table->index(['month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_sistems');
    }
};