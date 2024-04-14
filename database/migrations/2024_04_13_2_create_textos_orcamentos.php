<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('texto_orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('texto_prefixo')->nullable();
            $table->text('texto_completo')->nullable();
            $table->string('status',1);
            $table->timestamps();
        });


    DB::table('texto_orcamentos')->insert(
        [
            [
                'id' => 1,
                'texto_prefixo'=>'Prazo de Execução',
                'texto_completo'=> 'Nosso prazo para execução será de até 30 (trinta) dias.',
                'status' => 'A'
            ],
            [
                'id' => 2,
                'texto_prefixo'=>'Descrição dos Valores',
                'texto_completo'=> "Valor dos materiais, mão de obra e transportes: R$\nValor dos encargos fiscais: R$\nValor total:R$ (número por extenso)",
                'status' => 'A'
            ],
            [
                'id' => 3,
                'texto_prefixo'=>'Condições de Pagamento',
                'texto_completo'=> 'A combinar.',
                'status' => 'A'
            ],
            [
                'id' => 4,
                'texto_prefixo'=>'Dados Bancários Para Pagamento',
                'texto_completo'=> "Banco Itaú ag: 8482 C.C: 99773-4 Mondarc Ar Condicionado, Exaustão e Ventilação Ltda.\n".
                "CHAVE PIX: 43.702.887/0001-72\nVia boleto bancário. \n".
                "Obs: Para boletos em atraso será cobrado multa de 2% e juros de 1% a.m.\n".
                "Não prorrogamos nem cancelamos nossos boletos bancários.\n".
                "A contratação será válida após assinatura de contrato assinado pelo cliente.\n".
                "Não iniciamos a obra sem o pagamento de sinal.",
                'status' => 'A'
            ],
        ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('texto_orcamentos');
    }
};
