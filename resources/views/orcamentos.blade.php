<?php
    use App\Http\Controllers\PedidosController;
?>
@extends('adminlte::page')

@section('title', env('APP_NAME'))
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/main_custom.js"></script>
<script src="js/fichatecnica.js"></script>

@if (isset($tela) and $tela == 'pesquisa')
    @section('content_header')
        <div class="form-group row">
            <h1 class="m-0 text-dark col-sm-11 col-form-label">Pesquisa de {{ $nome_tela }}</h1>
        </div>
    @stop
    @section('content')
        <div class="right_col" role="main">

            <form id="filtro" action="fichatecnica" method="get" data-parsley-validate=""
                class="form-horizontal form-label-left" novalidate="">
                <div class="form-group row">
                    <label for="ep" class="col-sm-2 col-form-label">Numero Orçamento</label>
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
        </div>
    @stop
@else
    @section('content')
        <div id="toastsContainerTopRight" class="toasts-top-right fixed">
            <div class="toast fade show" role="alert" style="width: 350px" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="mr-auto">Alerta!</strong>
                    <small></small>
                    <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body textoAlerta" style="text-decoration-style: solid; font-weight: bold; font-size: larger;">
                </div>
            </div>
        </div>
        @if ($tela == 'alterar')
            @section('content_header')
                <h4 class="m-0 text-dark">Orçamentos</h4>
            @stop
            <form id="alterar" class="form_ficha" action="{{ $rotaAlterar }}" data-parsley-validate=""
                class="form-horizontal form-label-left" novalidate="" method="post">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <input type="hidden" id="id" name="id" class="form-control col-md-7 col-xs-12"
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
            <label for="ep" class="col-sm-2 col-form-label text-right">EP*</label>
            <div class="col-sm-1">
                <input type="text" id="ep" name="ep" class="form-control col-md-13"
                    value="@if (isset($fichatecnicas[0]->ep)) {{ $fichatecnicas[0]->ep }} @else{{ '' }} @endif">
            </div>
        </div>
        <div class="form-group row">
            <table class="table table-sm table-striped text-center" id="table_composicao_orcamento">
                <thead style="background-color: #b6b3b3">
                    <tr>
                        <th scope="col">Blank</th>
                        <th scope="col">tmp Usin</th>
                        <th scope="col">Uso%</th>
                        <th scope="col">BL/CJ</th>
                        <th scope="col">Material</th>
                    </tr>
                </thead>
                <tbody>

                    @if (isset($fichatecnicasitens))
                        <?php $count = 0 ?>
                        @foreach ($fichatecnicasitens as $key => $fichatecnicaitem)
                            <tr>
                                <td data-name="blank{{'_'.$count}}" class="blank{{'_'.$count}}" scope="row">@if(trim($fichatecnicaitem->blank) != '') {{trim($fichatecnicaitem->blank)}} @else {{ ''}} @endif</td>
                                <td data-name="tmp{{'_'.$count}}" class="tmp{{'_'.$count}}">@if(trim($fichatecnicaitem->blank) == '') {{ ''}} @else {{ PedidosController::formatarMinutoSegundo($fichatecnicaitem->tempo_usinagem) }}@endif</td>
                                <td data-name="qtde{{'_'.$count}}" class="qtde{{'_'.$count}}">@if($fichatecnicaitem->blank != '') {{$fichatecnicaitem->qtde_blank}} @else {{''}} @endif</td>
                                <td data-name="material_id{{'_'.$count}}" class="material_id{{'_'.$count}}"data-materialid="{{ trim($fichatecnicaitem->materiais_id) }}">
                                    @if(trim($fichatecnicaitem->materiais->material) != ''){{ trim($fichatecnicaitem->materiais->material) }}@else {{ ''}} @endif
                                </td>
                            </tr>
                            <?php $count++ ?>
                        @endforeach
                    @endif
            </table>
        </div>
        <hr class="my-1">
    </div>
        <hr class="my-4">
        <div class="form-group row">
            <div class="col-sm-10">
                <button class="btn btn-danger" onclick="window.history.back();" type="button">Cancelar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" id="salvar_orcamento" class="btn btn-primary">Salvar</button>
            </div>
        </div>
        </form>
    @stop
@endif
