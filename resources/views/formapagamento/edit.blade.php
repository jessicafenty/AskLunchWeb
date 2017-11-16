@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Editar Forma de Pagamento
@endsection

@section('contentheader_title')
    Editar Forma de Pagamento
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

                        <form action="{{route('formapagamento.update', $formapagamento->codigo)}}" class="form-horizontal" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="idDescricao" class="control-label col-sm-2">Descrição</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="descricao" id="descricao">
                                        <option value="Dinheiro" {{ "Dinheiro" === (isset($formapagamento->descricao) ? $formapagamento->descricao : '' ) ? 'selected' : '' }}>Dinheiro</option>
                                        <option value="Cartão de Crédito" {{ "Cartão de Crédito" === (isset($formapagamento->descricao) ? $formapagamento->descricao : '' ) ? 'selected' : '' }}>Cartão de Crédito</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="idStatus" class="control-label col-sm-2">Ativo</label>
                                <div class="col-md-10">
                                    <input name="status" type="checkbox" value="Ativo" {{ "Ativo" === (isset($formapagamento->status) ? $formapagamento->status : '' ) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                <a href="{{route('formapagamento.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">
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