@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Editar Bebida
@endsection

@section('contentheader_title')
    Editar Bebida
@endsection


@section('main-content')

    @include('erros')

    @if (Session::has('mensagem'))
        <div class="col-md-10 col-md-offset-1">
            <div class="box success alert-success">
                <div class="box-header with-border">
                    <h3 class="box-title" style="color:white">{{Session::get('mensagem')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool"
                                data-widget="remove" data-toggle="tooltip" title="Fechar">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Session::has('mensagemErro'))
        <div class="col-md-10 col-md-offset-1">
            <div class="box alert alert-danger">
                <div class="box-header with-border">
                    <h3 class="box-title" style="color:white">{{Session::get('mensagemErro')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool"
                                data-widget="remove" data-toggle="tooltip" title="Fechar">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="box">

                    <div class="box-body">

                        <form action="{{route('bebida.update', $bebida->codigo)}}" class="form-horizontal" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="inputDescricao" class="col-sm-2 control-label">Descrição</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" id="inputDescricao" name="descricao"
                                           value="{{$bebida->descricao}}" placeholder="Descrição">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="idQuantidade" class="control-label col-sm-2">Quantidade</label>
                                <div class="col-md-3" style="display: inline-block">
                                    <input type="number" class="form-control input-lg" id="inputQuantidade" name="quantidadeNum"
                                           value="{{preg_replace("/[^0-9]/", "", $bebida->quantidade)}}" placeholder="Quantidade">
                                    <select class="form-control" name="quantidade" id="quantidade">
                                        <option value="ml" {{ "ml" === (isset($bebida->quantidade) ? $bebida->quantidade : '' ) ? 'selected' : '' }}>ml</option>
                                        <option value="L" {{ "L" === (isset($bebida->quantidade) ? $bebida->quantidade : '' ) ? 'selected' : '' }}>L</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputValor" class="col-sm-2 control-label">Valor</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputValor" name="valor"
                                           value="{{$bebida->valor}}" placeholder="Valor">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="idTipo" class="control-label col-sm-2">Tipo</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="tipo" id="tipo">
                                        <option value="Refrigerante" {{ "Refrigerante" === (isset($bebida->tipo) ? $bebida->tipo : '' ) ? 'selected' : '' }}>Refrigerante</option>
                                        <option value="Cerveja" {{ "Cerveja" === (isset($bebida->tipo) ? $bebida->tipo : '' ) ? 'selected' : '' }}>Cerveja</option>
                                        <option value="Suco" {{ "Suco" === (isset($bebida->tipo) ? $bebida->tipo : '' ) ? 'selected' : '' }}>Suco</option>
                                        <option value="Água sem Gás" {{ "Água sem Gás" === (isset($bebida->tipo) ? $bebida->tipo : '' ) ? 'selected' : '' }}>Água sem Gás</option>
                                        <option value="Água com Gás" {{ "Água com Gás" === (isset($bebida->tipo) ? $bebida->tipo : '' ) ? 'selected' : '' }}>Água com Gás</option>
                                    </select>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                <a href="{{route('bebida.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">
                                    Voltar
                                </a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection