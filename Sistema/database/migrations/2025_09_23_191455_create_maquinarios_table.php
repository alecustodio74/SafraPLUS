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
        Schema::create('maquinarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produtor_id')
                  ->constrained('produtores')
                  ->onDelete('cascade');

            $table->string('nome');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->year('ano')->nullable();
            $table->text('descricao_atividade')->nullable();
            $table->decimal('custo_hora', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinarios');
    }
};