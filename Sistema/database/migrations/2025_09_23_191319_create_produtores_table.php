<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoresTable extends Migration
{
    public function up()
    {
        Schema::create('produtores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf_cnpj', 20)->unique();
            $table->string('propriedade')->nullable();
            $table->string('cultura_principal', 100)->nullable();
            $table->string('email')->unique();
            //$table->string('password');
            //$table->rememberToken(); 
            $table->string('telefone', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtores');
    }
}