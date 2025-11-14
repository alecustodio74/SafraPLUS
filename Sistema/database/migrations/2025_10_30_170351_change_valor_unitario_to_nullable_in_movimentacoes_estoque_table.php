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
        Schema::table('movimentacoes_estoque', function (Blueprint $table) {
            // Altera a coluna para permitir nulos
            $table->decimal('valor_unitario', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimentacoes_estoque', function (Blueprint $table) {
            // Reverte (torna-a não nula novamente)
            $table->decimal('valor_unitario', 10, 2)->nullable(false)->change();
        });
    }
};