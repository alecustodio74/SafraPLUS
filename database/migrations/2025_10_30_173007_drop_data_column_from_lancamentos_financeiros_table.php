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
        Schema::table('lancamentos_financeiros', function (Blueprint $table) {
            // Remove a coluna 'data' antiga e problemática
            if (Schema::hasColumn('lancamentos_financeiros', 'data')) {
                $table->dropColumn('data');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lancamentos_financeiros', function (Blueprint $table) {
            // Se precisarmos reverter, adiciona a coluna de volta
            if (!Schema::hasColumn('lancamentos_financeiros', 'data')) {
                $table->date('data')->nullable();
            }
        });
    }
};