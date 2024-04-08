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

        <form id="filtro" action="produtos" method="get" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
            <div class="form-group row">
                <label for="codigo" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-2">
                    <input type="text" id="id" name="id" class="form-control col-md-7 col-xs-12" value="@if (isset($request) && $request->input('id') != ''){{$request->input('id')}}@else @endif">
                </div>
                <label for="codigo" class="col-sm-1 col-form-label">Nome</label>
                <div class="col-sm-5">
                    <input type="text" id="nome" name="nome" class="form-control col-md-7 col-xs-12" value="@if (isset($request) && trim($request->input('nome')) != ''){{$request->input('nome')}}@else @endif">
                </div>
                <label for="status" class="col-sm-1 col-form-label"></label>
                <!-- <select class="form-control col-md-1" id="status" name="status"> -->
                    <!-- <option value="A" @if (isset($request) && $request->input('status') == 'A'){{ ' selected '}}@else @endif>Ativo</option> -->
                    <!-- <option value="I" @if (isset($request) && $request->input('status')  == 'I'){{ ' selected '}}@else @endif>Inativo</option> -->
                <!-- </select> -->
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
                      <th style="width: 10%;">ID</th>
                      <th style="width: 20%;">Nome</th>
                      <th style="width: 10%;">Preço</th>
                      <th style="width: 10%;">Categoria</th>
                      <th style="width: 10%;">Descrição</th>
                      <th style="width: 10%;">Sistema</th>
                      <th style="width: 10%;">Fabricante</th>
                      <th style="width: 10%;">Codigo</th>
                      <th style="width: 10%;">Quant</th>
                      <th style="width: 10%;">Preco Unitario</th>
                      <th style="width: 10%;">FAT</th>                    
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($produtos))
                        @foreach ($produtos as $produto)
                            <tr>
                                <th scope="row"><a href={{ URL::route($rotaAlterar, array('id' => $produto->id )) }}>{{$produto->id}}</a></th>
                                <td>{{$produto->nome}}</td>
                                <td>{{$produto->preco}}</td>
                                <td>{{$produto->nome_categoria}}</td>
                                <td>{{$produto->descricao}}</td>
                                <td>{{$produto->sistema}}</td>
                                <td>{{$produto->fabricante}}</td>
                                <td>{{$produto->codigo}}</td>
                                <td>{{$produto->quantidade}}</td>
                                <td>{{$produto->precounitario}}</td>
                                <td>{{$produto->fat}}</td>
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
                <label for="id" class="col-sm-2 col-form-label">Id</label>
                <div class="col-sm-2">
                <input type="text" id="id" name="id" class="form-control col-md-7 col-xs-12" readonly="true" value="@if (isset($produtos[0]->id)){{$produtos[0]->id}}@else{{''}}@endif">
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
                <label for="produtos" class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="nome"  value="@if (isset($produtos[0]->nome)){{$produtos[0]->nome}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Preço</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="preco"  value="@if (isset($produtos[0]->preco)){{$produtos[0]->preco}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Categoria</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="categoria"  name="nome_categoria"  readonly="true" value="@if (isset($produtos[0]->nome_categoria)){{$produtos[0]->nome_categoria}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Descrição</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="descricao"  value="@if (isset($produtos[0]->descricao)){{$produtos[0]->descricao}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Sistema</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="sistema"  value="@if (isset($produtos[0]->sistema)){{$produtos[0]->sistema}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Fabricante</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="fabricante"  value="@if (isset($produtos[0]->fabricante)){{$produtos[0]->fabricante}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Codigo</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="codigo"  value="@if (isset($produtos[0]->codigo)){{$produtos[0]->codigo}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Quantidade</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="quantidade"  value="@if (isset($produtos[0]->quantidade)){{$produtos[0]->quantidade}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">Preco Unitario</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="precounitario"  value="@if (isset($produtos[0]->precounitario)){{$produtos[0]->precounitario}}@else{{''}}@endif">
                </div>
            </div>
            <div class="form-group row">
                <label for="produtos" class="col-sm-2 col-form-label">FAT</label>
                <div class="col-sm-6">
                <input type="text" class="form-control is-invalid" required id="produtos"  name="fat"  value="@if (isset($produtos[0]->fat)){{$produtos[0]->fat}}@else{{''}}@endif">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-5">
                    <button class="btn btn-danger" onclick="window.history.back();" type="button">Cancelar</button>
                </div>
                <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                <!-- <div class="col-sm-2 text-right">
                    <button class="btn btn-danger">Excluir</button>
                </div> -->
            </div>
        </form>

    @stop
@endif
