<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoStatusTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_status', function (Blueprint $table) {
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->foreignId('status_id')->constrained('status_pedidos');
            $table->dateTime('data_hora');
            $table->primary(['pedido_id', 'status_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_status');
    }
}
