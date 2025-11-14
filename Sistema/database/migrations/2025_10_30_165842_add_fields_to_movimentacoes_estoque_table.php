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

            
            if (!Schema::hasColumn('movimentacoes_estoque', 'tipo_movimentacao')) {
                $table->string('tipo_movimentacao');
            }

            if (!Schema::hasColumn('movimentacoes_estoque', 'insumo_id')) {
                $table->foreignId('insumo_id')
                      ->constrained('insumos')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('movimentacoes_estoque', 'safra_id')) {
                $table->foreignId('safra_id')->nullable()
                      ->constrained('safras')
                      ->onDelete('set null');
            }

            if (!Schema::hasColumn('movimentacoes_estoque', 'quantidade')) {
                $table->decimal('quantidade', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('movimentacoes_estoque', 'valor_unitario')) {
                $table->decimal('valor_unitario', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('movimentacoes_estoque', 'data_movimentacao')) {
                $table->date('data_movimentacao')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimentacoes_estoque', function (Blueprint $table) {
            
            $columnsToDrop = [
                'tipo_movimentacao', 
                'insumo_id', 
                'safra_id', 
                'quantidade', 
                'valor_unitario', 
                'data_movimentacao'
            ];

            if (Schema::hasColumn('movimentacoes_estoque', 'insumo_id')) {
                $table->dropForeign(['insumo_id']);
            }
            if (Schema::hasColumn('movimentacoes_estoque', 'safra_id')) {
                $table->dropForeign(['safra_id']);
            }

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('movimentacoes_estoque', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};