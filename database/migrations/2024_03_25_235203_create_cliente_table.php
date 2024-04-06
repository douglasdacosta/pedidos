<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social',100);
            $table->string('nome_fantasia',100);
            $table->string('cnpj',14);
            $table->string('nome_responsavel',100)->nullable();
            $table->string('endereco', 200)->nullable();
            $table->integer('numero')->length(11)->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('bairro', 150)->nullable();
            $table->string('cidade', 150)->nullable();
            $table->string('estado', 40)->nullable();
            $table->string('telefone', 11)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('status',1);
            $table->timestamps();
        });

        DB::table('clientes')->insert(
            [
                [ 'razao_social' =>'4million Software', 'nome_fantasia' => '4million', 'cnpj' => '15000000000111', 'status' => 'A'],
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
