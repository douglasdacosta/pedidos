<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusPedidoTable extends Migration
{
    public function up()
    {
        Schema::create('status_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_pedidos');
    }
}