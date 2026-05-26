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
        Schema::table('custos_operacionais', function (Blueprint $table) {
            $table->decimal('quantidade', 10, 2)->nullable()->after('descricao');
            $table->decimal('preco_unitario', 15, 2)->nullable()->after('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custos_operacionais', function (Blueprint $table) {
            $table->dropColumn(['quantidade', 'preco_unitario']);
        });
    }
};
