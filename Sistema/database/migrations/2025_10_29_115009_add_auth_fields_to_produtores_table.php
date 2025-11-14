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
        Schema::table('produtores', function (Blueprint $table) {
            if (!Schema::hasColumn('produtores', 'password')) {
                $table->string('password');
            }
            if (!Schema::hasColumn('produtores', 'remember_token')) {
                $table->rememberToken();
            }
            if (!Schema::hasColumn('produtores', 'role')) {
                $table->string('role')->default('produtor'); // 'produtor' é o usuário comum
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtores', function (Blueprint $table) {
            //
        });
    }
};
