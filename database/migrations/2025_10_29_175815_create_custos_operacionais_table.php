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
        Schema::create('custos_operacionais', function (Blueprint $table) {
            $table->id();

            $table->foreignId('safra_id')
                  ->constrained('safras')
                  ->onDelete('cascade');

            $table->foreignId('maquinario_id')->nullable()
                  ->constrained('maquinarios')
                  ->onDelete('set null');

            $table->foreignId('mao_de_obra_id')->nullable()
                  ->constrained('mao_de_obra')
                  ->onDelete('set null');

            $table->date('data');
            $table->string('descricao');
            $table->decimal('valor', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custos_operacionais');
    }
};