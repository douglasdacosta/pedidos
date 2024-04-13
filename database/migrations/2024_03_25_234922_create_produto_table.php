<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2)->nullable();
            $table->unsignedBigInteger('categorias_id')->nullable();
            $table->foreign('categorias_id')->references('id')->on('categorias')->onDelete('set null');
            $table->string('fabricante', 100)->nullable();
            $table->string('codigo', 50)->nullable();
            $table->integer('quantidade')->nullable();
            $table->decimal('precounitario', 10, 2)->nullable();
            $table->string('fat', 50)->nullable();
            $table->string('moeda', 10)->nullable();
            $table->string('origempreco', 50)->nullable();
            $table->decimal('totaladotado', 10, 2)->nullable();
            $table->decimal('percentualdesconto', 5, 2)->nullable();
            $table->string('sistema', 50)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
