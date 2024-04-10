@extends('adminlte::page')

@section('title', env('APP_NAME'))
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/main_custom.js"></script>
<script src="js/Orcamento.js"></script>

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

            <form id="filtro" action="fichatecnica" method="get" data-parsley-validate=""
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
                                    <th>ID</th>
                                    <th>Codigo Orçamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($fichatecnicas))
                                    @foreach ($fichatecnicas as $fichatecnica)
                                        <tr>
                                            <th scope="row"><a
                                                    href={{ URL::route($rotaAlterar, ['id' => $fichatecnica->id]) }}>{{ $fichatecnica->id }}</a>
                                            </th>
                                            <td>{{ $fichatecnica->ep }}</td>
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
                            value="@if (isset($fichatecnicas[0]->id)) {{ $fichatecnicas[0]->id }}@else{{ '' }} @endif">
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
            <label for="ep" class="col-sm-2 col-form-label text-right">Numero Orçamento*</label>
            <div class="col-sm-1">
                <input type="text" id="ep" name="ep" class="form-control col-md-13"
                    value="@if (isset($fichatecnicas[0]->ep)) {{ $fichatecnicas[0]->ep }} @else{{ '' }} @endif">
            </div>
            <label for="blank" class="col-sm-2 col-form-label text-right text-sm-end">Material*</label>
            <div class="col-sm-4">
                <select class="form-control" id="material_id" name="material_id">
                    <option value=""></option>
                    @if (isset($materiais))
                        @foreach ($materiais as $material)
                            <option value="{{ $material->id }}">{{ $material->id . ' - ' . $material->nome }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="overlay" style="display: none;">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>   
            </div>
        </div>
        <div class="form-group row">
            <label for="qtde" class="col-sm-2 col-form-label text-right">Unid</label>
            <div class="col-sm-1">
                <input type="text" id="unid" name="unid" class="form-control col-md-13 sonumeros"
                    value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="qtde" class="col-sm-2 col-form-label text-right">Qtde*</label>
            <div class="col-sm-1">
                <input type="text" id="qtde" name="qtde" class="form-control col-md-13 sonumeros"
                    value="">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
            </div>
            <div class="col-sm-2">
                <button type="button" id="addComposicao" class="btn btn-success">Adicionar</button>
            </div>
        </div>
        <hr class="my-3">
        <label for="codigo" class="col-sm-10 col-form-label">Descrição dos Orcamentos</label>
        <div class="form-group row">
            <table class="table table-sm table-striped text-center" id="table_composicao">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Numero Orçamento.</th>
                        <th scope="col">Descrição dos Itens Orçados.</th>
                        <th scope="col">Unid.</th>
                        <th scope="col">Qtd.</th>
                    </tr>
                </thead>
                <tbody>

                    @if (isset($fichatecnicasitens))
                        @foreach ($fichatecnicasitens as $fichatecnicaitem)
                            <tr class="{{ 'blank_' . $fichatecnicaitem->blank }}{{ $fichatecnicaitem->materiais_id }}">
                                <td data-name="blank" class="blank" scope="row">{{ trim($fichatecnicaitem->blank) }}
                                </td>
                                <td data-name="qtde" class="qtde">{{ trim($fichatecnicaitem->qtde_blank) }}</td>
                                <th>
                                    <button type="button" class="close" aria-label="Close"
                                        data-blank="{{ $fichatecnicaitem->blank }}{{ $fichatecnicaitem->materiais_id }}"><span
                                            aria-hidden="true">&times;</span></button>
                                    <button type="button" class="close edita_composicao" style="padding-right: 20px"
                                        data-blank="{{ $fichatecnicaitem->blank }}{{ $fichatecnicaitem->materiais_id }}"><span
                                            aria-hidden="true">&#9998;</span></button>
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
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
