<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubprodutoTable extends Migration
{
    public function up()
    {
        Schema::create('subprodutos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->foreignId('produto_id')->constrained('produtos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subprodutos');
    }
}
