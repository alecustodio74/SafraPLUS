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
        Schema::create('mao_de_obra', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produtor_id')
                  ->constrained('produtores')
                  ->onDelete('cascade');
            
            $table->string('nome_ou_tipo');
            $table->decimal('custo_diario_hora', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mao_de_obra');
    }
};