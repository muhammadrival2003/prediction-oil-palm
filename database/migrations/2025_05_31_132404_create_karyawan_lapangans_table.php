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
        Schema::create('karyawan_lapangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('afdeling_id');
            $table->string('nama');
            $table->enum('jabatan', ['MDR Panen', 'MDR Pemeliharaan', 'Petugas Timbang BRD', 'Mandor', 'Asisten Kebun']);
            $table->date('tanggal_masuk');
            $table->string('lokasi_kerja');
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('afdeling_id')
                ->references('id')
                ->on('afdelings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_lapangans');
    }
};
