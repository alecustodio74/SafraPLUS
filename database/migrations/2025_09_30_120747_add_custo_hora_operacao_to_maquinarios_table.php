<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ... dentro do arquivo de migration

    public function up(): void
    {
        Schema::table('maquinarios', function (Blueprint $table) {
            $table->decimal('custo_hora_operacao', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maquinarios', function (Blueprint $table) {
            //
        });
    }
};
