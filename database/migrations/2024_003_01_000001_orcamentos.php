<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_id')->unsigned()->index();
            $table->bigInteger('status_id')->unsigned()->index();
            $table->text('texto_orcamento');
            $table->text('dados_json');
            $table->text('observacoes_exclusoes');
            $table->text('prazo_execucao');
            $table->integer('garantia');
            $table->integer('exibir_valores_orcamento');
            $table->text('descricao_valores');
            $table->text('condicoes_pagamentos');
            $table->text('dados_bancarios_pagamento');
            $table->string('status', 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamentos');
    }
};
