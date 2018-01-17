@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Editar Cliente
@endsection

@section('contentheader_title')
    Editar Cliente
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

                        <form action="{{route('cliente.update', $cliente->codigo)}}" class="form-horizontal" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}

                            <fieldset>
                                <legend>Dados Pessoais</legend>
                                <div class="form-group">
                                    <label for="inputNome" class="col-sm-2 control-label">Nome</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputNome" name="nome"
                                               value="{{$cliente->nome}}" placeholder="Nome do Funcionario">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputTelefone" class="col-sm-2 control-label">Telefone</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputTelefone" name="telefone"
                                               value="{{$cliente->telefone}}" placeholder="Telefone">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputDataNasc" class="col-sm-2 control-label">Data Nascimento</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control input-lg" id="inputDataNasc" name="data_nascimento"
                                               value="{{date('Y-m-d',strtotime(str_replace('/', '-', $cliente->data_nascimento)))}}" placeholder="Data de Nascimento">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Endereço</legend>
                                <div class="form-group">
                                    <label for="inputLogradouro" class="col-sm-2 control-label">Logradouro</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputLogradouro" name="logradouro"
                                               value="{{$cliente->logradouro}}" placeholder="Logradouro">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputBairro" class="col-sm-2 control-label">Bairro</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputBairro" name="bairro"
                                               value="{{$cliente->bairro}}" placeholder="Bairro">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputNumero" class="col-sm-2 control-label">Número</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input-lg" id="inputNumero" name="numero"
                                               value="{{$cliente->numero}}" placeholder="Número">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputQuadra" class="col-sm-2 control-label">Quadra</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input-lg" id="inputQuadra" name="quadra"
                                               value="{{$cliente->quadra}}" placeholder="Quadra">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputLote" class="col-sm-2 control-label">Lote</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input-lg" id="inputLote" name="lote"
                                               value="{{$cliente->lote}}" placeholder="Lote">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Usuário</legend>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">E-mail</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control input-lg" id="inputEmail" name="email"
                                               value="{{$cliente->usuario->email}}" placeholder="E-mail">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputSenha" class="col-sm-2 control-label">Senha</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control input-lg" id="inputSenha" name="senha"
                                               value="{{$cliente->usuario->senha}}" placeholder="Senha">
                                    </div>
                                </div>

                            </fieldset>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                <a href="{{route('cliente.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">
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