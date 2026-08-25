@extends('adminlte::page')

@section('title', env('APP_NAME'))
{{-- <script src="js/jquery_v3.1.1.js"></script> --}}
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/main_custom.js"></script>

@if(isset($tela) and $tela == 'pesquisa')
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

        <form id="filtro" action="materiais" method="get" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
            <div class="form-group row">
                <label for="codigo" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-2">
                    <input type="text" id="codigo" name="codigo" class="form-control col-md-7 col-xs-12" value="@if (isset($request) && $request->input('codigo') != ''){{$request->input('codigo')}}@else @endif">
                </div>
                <label for="codigo" class="col-sm-1 col-form-label">Materiais</label>
                <div class="col-sm-5">
                    <input type="text" id="nome" name="nome" class="form-control col-md-7 col-xs-12" value="@if (isset($request) && trim($request->input('nome')) != ''){{$request->input('nome')}}@else @endif">
                </div>
                <label for="status" class="col-sm-1 col-form-label"></label>
                <select class="form-control col-md-1" id="status" name="status">
                    <option value="A" @if (isset($request) && $request->input('status') == 'A'){{ ' selected '}}@else @endif>Ativo</option>
                    <option value="I" @if (isset($request) && $request->input('status')  == 'I'){{ ' selected '}}@else @endif>Inativo</option>
                </select>
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
                <table class="table table-striped  text-center ">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Código</th>
                      <th>Material</th>
                      <th>Valor</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($materiais))
                        @foreach ($materiais as $material)
                            <tr>
                            <th scope="row"><a href={{ URL::route($rotaAlterar, array('id' => $material->id )) }}>{{$material->id}}</a></th>
                              <td>{{$material->codigo}}</td>
                              <td>{{$material->material}}</td>
                              <td>{{number_format($material->valor,2, ',','.')}}</td>

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
        @if($tela == 'alterar')
            @section('content_header')
                <h1 class="m-0 text-dark">Alteração de {{ $nome_tela }}</h1>
            @stop
            <form id="alterar" action="{{$rotaAlterar}}" data-parsley-validate="" class="form-horizontal form-label-left" method="post">
            <div class="form-group row">
                <label for="codigo" class="col-sm-2 col-form-label">Id</label>
                <div class="col-sm-2">
                <input type="text" id="id" name="id" class="form-control col-md-7 col-xs-12" readonly="true" value="@if (isset($materiais[0]->id)){{$materiais[0]->id}}@else{{''}}@endif">
                </div>
            </div>
        @else
            @section('content_header')
                <h1 class="m-0 text-dark">Inclusão de {{ $nome_tela }}</h1>
            @stop
            <form id="incluir" action="{{$rotaIncluir}}" data-parsley-validate="" class="form-horizontal form-label-left" method="post">
        @endif
            @csrf <!--{{ csrf_field() }}-->
            <div class="form-group row">
                <label for="codigo" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-2">
                <input type="text" class="form-control is-invalid" id="codigo" name="codigo" required value="@if (isset($materiais[0]->codigo)){{$materiais[0]->codigo}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="Material" class="col-sm-2 col-form-label">Material</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="material"  name="material"  value="@if (isset($materiais[0]->material)){{$materiais[0]->material}}@else{{''}}@endif">
                </div>
            </div>
            @if (!empty($historicos))
                <div class="form-group row">
                    <label for="observacao" class="col-sm-2 col-form-label">Histórico</label>
                    <div class="col-sm-8">
                        <div class="d-flex p-2 bd-highlight overflow-auto">
                            @foreach ($historicos as $historico)
                                {{ '[' . \Carbon\Carbon::parse($historico->created_at)->format('d/m/Y h:i:s') . '] ' . $historico->historico }}</br>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <div class="col-sm-5">
                    <button class="btn btn-danger" onclick="window.history.back();" type="button">Cancelar</button>
                </div>
                <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>

    @stop
@endif
