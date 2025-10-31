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
        Schema::create('safras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produtor_id')->constrained('produtores')->onDelete('cascade');
            $table->string('cultura', 100);
            $table->decimal('area_plantada', 10, 2)->nullable();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('localizacao', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safras');
    }
};