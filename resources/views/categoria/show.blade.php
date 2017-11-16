@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Informações da Categoria
@endsection

@section('contentheader_title')
    Informações da Categoria
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

    <div class="container-fluid spark-screen">

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <div class="box">

                    <div style="font-size: x-large;text-align: center;">
                        <h2 class="box-title">{{$categoria->tamanho}}</h2>
                    </div>

                    <div class="box-body">

                        <div class="jumbotron">

                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Valor: </strong> {{$categoria->valor}}<br>
                            </div>

                        </div>
                        <a href="{{route('categoria.index')}}" class="btn btn-small btn-primary pull-right btn-lg" style="float: right">
                            Voltar
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection