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
        Schema::table('safras', function (Blueprint $table) {
            $table->string('propriedade')->nullable()->after('area_plantada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('safras', function (Blueprint $table) {
            $table->dropColumn('propriedade');
        });
    }
};
