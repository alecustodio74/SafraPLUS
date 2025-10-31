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
        Schema::create('lancamentos_financeiros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('safra_id')
                  ->constrained('safras')
                  ->onDelete('cascade');

            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onDelete('cascade');

            $table->date('data');
            $table->string('descricao')->nullable();
            $table->string('tipo_receita_custo'); // 'receita' ou 'custo'
            $table->decimal('valor_total', 10, 2);
            $table->decimal('valor_liquido', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamentos_financeiros');
    }
};