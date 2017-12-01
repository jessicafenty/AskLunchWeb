@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Informações do Pedido
@endsection

@section('contentheader_title')
    Informações do Pedido
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
                        <h2 class="box-title">{{$pedido->funcionario->nome}}</h2>
                    </div>

                    <div class="box-body">

                        <div class="jumbotron">

                            <h3 style="background-color: white; text-align: center">Informações de Contato</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Telefone: </strong> {{$cliente->telefone}}<br>
                                <strong>E-mail: </strong> {{$usuario->email}}<br>
                            </div>

                            <h3 style="background-color: white; text-align: center">Informações de Pagamento</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Forma de Pagamento: </strong> {{$pedido->formapagamento->descricao}}<br>
                                <strong>Troco: </strong> {{$pedido->troco}}<br>
                            </div>
                            <h3 style="background-color: white; text-align: center">Informações de Pedido</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Entrega: </strong> {{$pedido->entrega}}<br>
                                <strong>Horário: </strong> {{$pedido->horario}}<br>
                                <strong>Status: </strong> {{$pedido->status}}<br>
                                <strong>Entregador: </strong> {{$pedido->entregador === 'Padrão' ? '-' : $pedido->entregador}}<br>
                            </div>
                            <h3 style="background-color: white; text-align: center">Informações de Endereço</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large">
                                <strong>Logradouro: </strong> {{$pedido->logradouro}}<br>
                                <strong>Bairro: </strong> {{$pedido->bairro}}<br>
                                <strong>Número: </strong> {{$pedido->numero}}<br>
                                <strong>Quadra: </strong> {{$pedido->quadra}}<br>
                                <strong>Lote: </strong> {{$pedido->lote}}<br>
                            </div>

                        </div>
                        <a href="{{route('pedido.index')}}" class="btn btn-small btn-primary pull-right btn-lg" style="float: right">
                            Voltar
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection