<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('observacoes_exclusoes', function (Blueprint $table) {
            $table->id();
            $table->string('texto_prefixo')->nullable();
            $table->text('texto_completo')->nullable();
            $table->string('status',1);
            $table->timestamps();

        });
        DB::table('observacoes_exclusoes')->insert(
            [
                [
                    'texto_prefixo'=>'Não estamos considerando em nosso escopo, o fornecimento de mão de obra...',
                    'texto_completo'=> 'Não estamos considerando em nosso escopo, o fornecimento de mão de obra especializada em civil, ficando a cargo da contratante a abertura e recomposição de paredes, pisos, forros e telhados, construção de bases de alvenaria, plataformas técnicas, reforços, grades de proteção etc;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando em nossa proposta o fornecimento de pontos de força...',
                    'texto_completo'=> 'Não estamos considerando em nossa proposta o fornecimento de pontos de força, devidamente protegidos para os equipamentos de ar-condicionado e exaustão mecânica;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando em nossa proposta o fornecimento de pontos de drenos...',
                    'texto_completo'=> 'Não estamos considerando em nossa proposta o fornecimento de pontos de drenos, devidamente isolados para o descarte de água de condensação dos condicionadores de ar;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Estamos considerando em nossa proposta que os pontos de espera de água...',
                    'texto_completo'=> 'Estamos considerando em nossa proposta que os pontos de espera de água gelada são existentes, não havendo necessidade de furação em carga;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando em nossa proposta o fornecimento de furações em carga...',
                    'texto_completo'=> 'Não estamos considerando em nossa proposta o fornecimento de furações em carga, congelamento de linha, etc. para a instalação do complemento de tubulação de água gelada;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Estamos considerando que a Central de Água Gelada tem carga térmica suficiente...',
                    'texto_completo'=> 'Estamos considerando que a Central de Água Gelada tem carga térmica suficiente para o devido funcionamento dos equipamentos de ar-condicionado;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando em nosso escopo, o fornecimento de complemento de equipamentos...',
                    'texto_completo'=> 'Não estamos considerando em nosso escopo, o fornecimento de complemento de equipamentos para a central de água gelada;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Estamos considerando o reaproveitamento dos dutos, conforme indicados em projeto...',
                    'texto_completo'=> 'Estamos considerando o reaproveitamento dos dutos, conforme indicados em projeto, ficando fora de nosso escopo o serviço de limpeza interna dos dutos;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Estamos considerando que as caixas polares serão fornecidas e instaladas...',
                    'texto_completo'=> 'Estamos considerando que as caixas polares serão fornecidas e instaladas pelo instalador de civil;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando o fornecimento de ventiladores para renovação de ar',
                    'texto_completo'=> 'Não estamos considerando o fornecimento de ventiladores para renovação de ar;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando o fornecimento de exaustores para todos os sanitários...',
                    'texto_completo'=> 'Não estamos considerando o fornecimento de exaustores para todos os sanitários, entendemos que os mesmos terão ventilação natural;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Não estamos considerando o fornecimento de coifas de ar na cozinha;',
                    'texto_completo'=> 'Não estamos considerando o fornecimento de coifas de ar na cozinha;',
                    'status' => 'A'
                ],
                [
                    'texto_prefixo'=>'Estamos considerando esta proposta uma estimativa de valores...',
                    'texto_completo'=> 'Estamos considerando esta proposta uma estimativa de valores, por não existir projeto na disciplina de HVAC.',
                    'status' => 'A'
                ],
            ]
            );
    }

    public function down()
    {
        Schema::dropIfExists('observacoes_exclusoes');
    }
};
