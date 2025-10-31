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
            // Adiciona a coluna que está em falta
            if (!Schema::hasColumn('lancamentos_financeiros', 'data_lancamento')) {
                $table->date('data_lancamento')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lancamentos_financeiros', function (Blueprint $table) {
            if (Schema::hasColumn('lancamentos_financeiros', 'data_lancamento')) {
                $table->dropColumn('data_lancamento');
            }
        });
    }
};