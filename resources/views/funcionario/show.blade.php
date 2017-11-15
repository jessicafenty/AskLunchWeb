@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Informações do Funcionário
@endsection

@section('contentheader_title')
    Informações do Funcionário
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
                        <h2 class="box-title">{{$funcionario->nome}}</h2>
                    </div>

                    <div class="box-body">

                        <div class="jumbotron">

                            <h3 style="background-color: white; text-align: center">Dados Pessoais</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Telefone: </strong> {{$funcionario->telefone}}<br>
                                <strong>Data de Nascimento: </strong> {{$funcionario->data_nascimento}}<br>
                            </div>
                            <h3 style="background-color: white; text-align: center">Endereço</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Logradouro: </strong> {{$funcionario->logradouro}}<br>
                                <strong>Bairro: </strong> {{$funcionario->bairro}}<br>
                                <strong>Número: </strong> {{$funcionario->numero}}<br>
                                <strong>Quadra: </strong> {{$funcionario->quadra}}<br>
                                <strong>Lote: </strong> {{$funcionario->lote}}<br>
                            </div>
                            <h3 style="background-color: white; text-align: center">Dados de Usuário</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>E-mail: </strong> {{$funcionario->usuario->email}}<br>
                                <strong>Tipo de Usuário: </strong> {{$funcionario->usuario->tipo}}<br>
                            </div>

                        </div>
                        <a href="{{route('funcionario.index')}}" class="btn btn-small btn-primary" style="float: right">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            Voltar
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection