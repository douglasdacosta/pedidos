<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
        DB::table('categorias')->insert(
            [
                [ 'nome' =>'Rede De Duto', 'descricao' => 'teste1' ],
                [ 'nome' =>'Rede Frigorígena', 'descricao' => 'teste2'],
                [ 'nome' =>'Acessórios Diversos', 'descricao' => 'teste3'],
                [ 'nome' =>'Rede Elétrica', 'descricao' => 'teste4'],
                [ 'nome' =>'Rede Hidraulica', 'descricao' => 'teste5'],
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}