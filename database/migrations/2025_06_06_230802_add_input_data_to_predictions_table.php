<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->json('input_data')->nullable()->after('prediction');
            $table->decimal('confidence_score', 5, 2)->nullable()->after('input_data');
        });
    }

    public function down()
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropColumn(['input_data', 'confidence_score']);
        });
    }
};