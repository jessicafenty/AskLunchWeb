@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Cadastrar Categoria
@endsection

@section('contentheader_title')
    Cadastrar Categoria
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

                        <form class="form-horizontal" action="{{action('CategoriaController@store')}}" method="post">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">

                                <div class="form-group">
                                    <label for="idTamanho" class="control-label col-sm-2">Tamanho</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="tamanho" id="tamanho">
                                            <option value="Grande">Grande</option>
                                            <option value="Pequena">Pequena</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputValor" class="col-sm-2 control-label">Valor</label>
                                    <div class="col-sm-10">
                                        <input type="number" step="any" min="0" class="form-control input-lg" id="inputValor" name="valor"
                                               value="{{old('valor')}}" placeholder="Valor">
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