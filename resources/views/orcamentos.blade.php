<?php
    use App\Http\Controllers\PedidosController;
?>
@extends('adminlte::page')

@section('title', env('APP_NAME'))
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/main_custom.js"></script>
<script src="js/orcamento.js"></script>

@if (isset($tela) and $tela == 'pesquisa')
    @section('content_header')
        <div class="form-group row">
            <h1 class="m-0 text-dark col-sm-11 col-form-label">Pesquisa de {{ $nome_tela }}</h1>
            <div class="col-sm-1">
                @include('layouts.nav-open-incluir', ['rotaIncluir => $rotaIncluir'])
            </div>
        </div>
    @stop
    @section('content')
        <div class="right_col" role="main">

            <form id="filtro" action="orcamentos" method="get" data-parsley-validate=""
                class="form-horizontal form-label-left" novalidate="">
                <div class="form-group row">
                    <label for="ep" class="col-sm-2 col-form-label">EP</label>
                    <div class="col-sm-2">
                        <input type="text" id="ep" name="ep" class="form-control col-md-7 col-xs-12"
                            value="@if (isset($request) && $request->input('ep') != '') {{ $request->input('ep') }}@else @endif">
                    </div>
                    <label for="status" class="col-sm-1 col-form-label"></label>
                    <select class="form-control col-md-1" id="status" name="status">
                        <option value="A" @if (isset($request) && $request->input('status') == 'A') {{ ' selected ' }}@else @endif>Ativo
                        </option>
                        <option value="I" @if (isset($request) && $request->input('status') == 'I') {{ ' selected ' }}@else @endif>Inativo
                        </option>
                    </select>
                </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
            <div class="col-sm-5">
            </div>
        </div>
        </form>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""></label>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h4>Encontrados</h4>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped  text-center">
                            <thead>
                                <tr>
                                    <th>Codigo Orçamento</th>
                                    <th>Cliente</th>
                                    <th>Status do Orçamento</th>
                                    <th>Data gerado</th>
                                    <th>Impressão</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($fichatecnicas))
                                    @foreach ($fichatecnicas as $fichatecnica)
                                        <tr>
                                            <th scope="row"><a
                                                    href={{ URL::route($rotaAlterar, ['id' => $fichatecnica->id]) }}>{{ $fichatecnica->id }}</a>
                                            </th>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>

    @stop
@else
@section('content')
<div id="toastsContainerTopRight" class="toasts-top-right fixed">
    <div class="toast bg-danger fade show" role="alert" style="width: 350px" aria-live="assertive"
        aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Alerta!</strong>
            <small></small>
            <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body textoAlerta"
            style="text-decoration-style: solid; font-weight: bold; font-size: larger;"></div>
    </div>
</div>
@if ($tela == 'alterar')
    @section('content_header')
        <h4 class="m-0 text-dark">Alteração de {{ $nome_tela }}</h4>
    @stop
    <form id="alterar" class="form_ficha" action="{{ $rotaAlterar }}" data-parsley-validate=""
        class="form-horizontal form-label-left" novalidate="" method="post">
        <div class="form-group row">
            <label for="codigo" class="col-sm-2 col-form-label">Id</label>
            <div class="col-sm-2">
                <input type="text" id="id" name="id" class="form-control col-md-7 col-xs-12"
                    readonly="true"
                    value="@if (isset($orcamentos[0]->id)) {{ $orcamentos[0]->id }}@else{{ '' }} @endif">
            </div>
        </div>
    @else
        @section('content_header')
            <h1 class="m-0 text-dark">Inclusão de {{ $nome_tela }}</h1>
        @stop
        <form id="incluir" class="form_ficha" action="{{ $rotaIncluir }}" data-parsley-validate=""
            class="form-horizontal form-label-left" novalidate="" method="post">
@endif
@csrf <!--{{ csrf_field() }}-->

<div class="form-group row">
    <label for="blank" class="col-sm-2 col-form-label text-right text-sm-end">Clientes*</label>
    <div class="col-sm-4">
        <select class="form-control" id="material_id" name="material_id">
            <option value=""></option>
            @if (isset($clientes))
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome_fantasia }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="texto_orcamento" class="col-sm-2 col-form-label text-right text-sm-end">Texto orçamento</label>
    <div class="col-sm-6">
        <textarea class="form-control" id="texto_orcamento" name="texto_orcamento">
@if (isset($orcamentos[0]->texto_orcamento))
{{ trim($orcamentos[0]->texto_orcamento) }}@else{{ '' }}
@endif
</textarea>
    </div>
</div>
<hr class="my-3">

<div class="form-group row">
    <label for="blank" class="col-sm-2 col-form-label text-right text-sm-end">Produto*</label>
    <div class="col-sm-4">
        <select class="form-control" id="produto" name="produto">
            <option value=""></option>
            @if (isset($produtos))
                @foreach ($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->id . ' - ' . $produto->nome }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="overlay" style="display: none;">
        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
    </div>
    <label for="qtde" class="col-sm-1 col-form-label text-right">Qtde*</label>
    <div class="col-sm-1">
        <input type="text" id="qtde" name="qtde" class="form-control col-md-13 sonumeros"
            value="">
    </div>
    <div class="col-sm-2">
        <button type="button" id="addComposicao" class="btn btn-success">Adicionar</button>
    </div>
</div>

<label for="codigo" class="col-sm-10 col-form-label">Descrição dos Orçamentos</label>
<div class="form-group row">
    <table class="table table-sm table-striped text-center" id="table_composicao">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Categoria</th>
                <th scope="col">Produto</th>
                <th scope="col">Descrição</th>
                <th scope="col">Unidade medida</th>
                <th scope="col">Preço Unit</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>

            @if (isset($orcamentos))
                @foreach ($orcamentos as $orcamento)
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<hr class="my-3">


<div class="form-group row">
    <label for="blank" class="col-sm-2 col-form-label text-right text-sm-end">Textos Obs e Exc*</label>
    <div class="col-sm-4">
        <select class="form-control" id="produto" name="produto">
            <option value=""></option>
            @if (isset($textos_observacao_execucao))
                @foreach ($textos_observacao_execucao as $textos_observacao_execucao)
                    <option value="{{ $textos_observacao_execucao->id }}">{{ $textos_observacao_execucao->texto_prefixo }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="overlay" style="display: none;">
        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
    </div>
    <div class="col-sm-2">
        <button type="button" id="addComposicao" class="btn btn-success">Adicionar</button>
    </div>
</div>
<div class="form-group row">
    <label for="observacoes_exclusoes" class="col-sm-2 col-form-label text-right text-sm-end">Observações e Exclusões</label>
    <div class="col-sm-6">
        <textarea class="form-control" id="observacoes_exclusoes" name="observacoes_exclusoes">
@if (isset($orcamentos[0]->observacoes_exclusoes))
{{ trim($orcamentos[0]->observacoes_exclusoes) }}@else{{ '' }}
@endif
</textarea>
    </div>
</div>
<hr class="my-3">
<div class="form-group row">
    <label for="prazo_execucao" class="col-sm-2 col-form-label text-right text-sm-end">Prazo de Execução</label>
    <div class="col-sm-6">
        <textarea class="form-control" id="prazo_execucao" name="prazo_execucao">@if (isset($orcamentos[0]->prazo_execucao)){{ trim($orcamentos[0]->prazo_execucao) }}@else{{ $textos_orcamentos[0]['texto_completo'] }}@endif</textarea>
    </div>
</div>
<hr class="my-3">
<div class="form-group row">
    <label for="garantia" class="col-sm-2 col-form-label text-right text-sm-end">Garantia</label>
    <select class="form-control col-md-8" id="garantia" name="garantia">
        <option value="1" @if (isset($orcamento[0]->garantia) && $orcamento[0]->garantia == '1') {{ ' selected ' }}@else @endif>Todos os nossos serviços e materiais terão direito a garantia de 01 (um) ano contra defeitos de
            fabricação e instalação, exceto àqueles que apresentarem falhas ou falta de manutenção.</option>
        <option value="2" @if (isset($orcamento[0]->garantia) && $orcamento[0]->garantia == '2') {{ ' selected ' }}@else @endif>Todos os nossos serviços e materiais terão direito a garantia de 03 (três) meses contra defeitos de
            fabricação e instalação, exceto aqueles existentes ou que apresentarem falhas ou falta de
            manutenção</option>
    </select>
</div>
<hr class="my-3">
<div class="form-group row">
    <label for="exibir_valores_orcamento" class="col-sm-2 col-form-label text-right text-sm-end">Exibir valores no orçamento</label>
    <select class="form-control col-md-2" id="exibir_valores_orcamento" name="exibir_valores_orcamento">
        <option value="1" @if (isset($orcamento[0]->garantia) && $orcamento[0]->garantia == '1') {{ ' selected ' }}@else @endif>Sim</option>
        <option value="2" @if (isset($orcamento[0]->garantia) && $orcamento[0]->garantia == '2') {{ ' selected ' }}@else @endif>Não</option>
    </select>
</div>
    <div class="form-group row">

    <label for="descricao_valores" class="col-sm-2 col-form-label text-right text-sm-end">Descrição dos Valores</label>
    <div class="col-sm-6">
        <textarea class="form-control" rows="4" id="descricao_valores" name="descricao_valores">@if (isset($orcamentos[0]->descricao_valores)){{ trim($orcamentos[0]->descricao_valores) }}@else{{$textos_orcamentos[1]['texto_completo'] }}
            @endif
        </textarea>
    </div>
</div>
<hr class="my-3">
<div class="form-group row">
    <label for="condicoes_pagamentos" class="col-sm-2 col-form-label text-right text-sm-end">Condições de Pagamento</label>
    <div class="col-sm-6">
        <textarea class="form-control" id="condicoes_pagamentos" name="condicoes_pagamentos">@if (isset($orcamentos[0]->condicoes_pagamentos)){{ trim($orcamentos[0]->condicoes_pagamentos) }}@else{{$textos_orcamentos[2]['texto_completo'] }}@endif</textarea>
    </div>
</div>
<hr class="my-3">
<div class="form-group row">
    <label for="dados_bancarios_pagamento" class="col-sm-2 col-form-label text-right text-sm-end">Dados Bancários Para Pagamento</label>
    <div class="col-sm-6">
        <textarea class="form-control" rows="10"  id="dados_bancarios_pagamento" name="dados_bancarios_pagamento">@if (isset($orcamentos[0]->dados_bancarios_pagamento)){{ trim($orcamentos[0]->dados_bancarios_pagamento) }}@else{{$textos_orcamentos[3]['texto_completo'] }}
            @endif
        </textarea>
    </div>
</div>
<input type="hidden" id='composicoes' name="composicoes" value=''>
<div class="form-group row">
    <div class="col-sm-10">
        <button class="btn btn-danger" onclick="window.history.back();" type="button">Cancelar</button>
    </div>
    <div class="col-sm-2">
        <button type="button" id="salvar_ficha" class="btn btn-primary">Salvar</button>
    </div>
</div>
</form>
@stop
@endif
