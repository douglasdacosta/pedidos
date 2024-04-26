@extends('layouts.app_impressao')

{{-- <link rel="stylesheet" href="{{asset('css/orcamento.css')}}" /> --}}
<link rel="stylesheet" href="{{public_path('css/orcamento.css')}}" />

@section('content')
    <div class="contenedor" >
        <div id="orcamentos_impressao" >
        </div>
        <div class="form-group row">
            <table>
                <tbody>
                    <tr>
                        <td><img class="logo"  style=" width: 250px; height: 100px;" src='data:image/png;base64,{{ base64_encode(file_get_contents(public_path('imagens/Logo_mondarc.png')))}}' /></td>
                        <td></td><td class="text-right">Prop. nº. F125/24</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right">{{$data_descricao}}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <p class="col-sm-8 text-bold" >
                    {!! nl2br($responsavel) !!}
                </p>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <p class="col-sm-12 text-bold" >
                    {{$orcamentos['texto_orcamento']}}

                </p>
            </div>
        </div>
        <div class="form-group row">
                <table class="table table-striped table-sm text-center">
                    <thead>
                        <tr class="table-primary">
                            <th>ID</th>
                            <th>Descrição dos Itens</th>
                            <th>Unidade</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                        @foreach ($composicao as $item)

                        <tr>
                            <td>{{$item[0]['produto_id']}}</td>
                            <td>{{$item[2]['produto']}}</td>
                            <td>{{$item[4]['unidade']}}</td>
                            <td>{{$item[5]['preco_unitario']}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <h5>Observações e Exclusões</h5>
                    <p class="col-sm-12 text-bold" >
                        {{$orcamentos['observacoes_exclusoes']}}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <h5>Prazo de Execução</h5>
                    <p class="col-sm-12 text-bold" >
                        {{$orcamentos['prazo_execucao']}}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <h5>Garantia</h5>
                    <p class="col-sm-12 text-bold" >
                        @if($orcamentos['garantia'] == 1) {{'Todos os nossos serviços e materiais terão direito a garantia de 01 (um) ano contra defeitos de
                        fabricação e instalação, exceto àqueles que apresentarem falhas ou falta de manutenção'}}
                        @else {{"Todos os nossos serviços e materiais terão direito a garantia de 03 (três) meses contra defeitos de
                            fabricação e instalação, exceto aqueles existentes ou que apresentarem falhas ou falta de
                            manutenção"}}
                        @endif
                    </p>
                </div>
            </div>
            @if($orcamentos['exibir_valores_orcamento'] == 1)
                <div class="form-group row">
                    <div class="col-sm-12">
                        <h5>Descrição dos Valores</h5>
                        <p class="col-sm-12 text-bold" >
                            {!! nl2br($orcamentos['descricao_valores']) !!}
                        </p>
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <div class="col-sm-12">
                    <h5>Condições de Pagamento</h5>
                    <p class="col-sm-12 text-bold" >
                        {!! nl2br($orcamentos['condicoes_pagamentos']) !!}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <h5>Dados Bancários Para Pagamento</h5>
                    <p class="col-sm-12 text-bold" >
                        {!! nl2br($orcamentos['dados_bancarios_pagamento']) !!}
                    </p>
                </div>
            </div>


    </div>
@stop
