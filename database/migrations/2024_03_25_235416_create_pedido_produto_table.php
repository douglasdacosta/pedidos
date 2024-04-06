<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoProdutoTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_produto', function (Blueprint $table) {
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->foreignId('produto_id')->constrained('produtos');
            $table->integer('quantidade')->default(1);
            $table->primary(['pedido_id', 'produto_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_produto');
    }
}
