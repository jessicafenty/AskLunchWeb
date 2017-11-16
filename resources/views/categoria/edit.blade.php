@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Editar Categoria
@endsection

@section('contentheader_title')
    Editar Categoria
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

                        <form action="{{route('categoria.update', $categoria->codigo)}}" class="form-horizontal" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="idTamanho" class="control-label col-sm-2">Tamanho</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="tamanho" id="tamanho">
                                        <option value="Grande" {{ "Grande" === (isset($categoria->tamanho) ? $categoria->tamanho : '' ) ? 'selected' : '' }}>Grande</option>
                                        <option value="Pequena" {{ "Pequena" === (isset($categoria->tamanho) ? $categoria->tamanho : '' ) ? 'selected' : '' }}>Pequena</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputValor" class="col-sm-2 control-label">Valor</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputValor" name="valor"
                                           value="{{$categoria->valor}}" placeholder="Valor">
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                <a href="{{route('categoria.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">
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