@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Categorias
@endsection

@section('contentheader_title')
    Categorias
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">

                <div class="box">

                    <div class="box-header with-border" align="center">

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
                                <div class="col-md-12">
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

                        {{--<a href="{{route('categoria.create')}}" class="btn btn-small btn-primary col-md-12">--}}
                            {{--<i class="fa fa-plus-circle"></i>--}}
                            {{--Novo--}}
                        {{--</a>--}}
                    </div>

                    <div class="box-body" align="center">
                        <form action="{{route('valor.marmitas')}}" method="post">
                            {{ csrf_field() }}

                        @foreach($categoria as $c)

                            <label style="margin-top: 25px;font-weight: bold" for="inputValor" class="col-sm-2 control-label">{{$c->tamanho}}</label>
                            <div class="form-group" style="display: inline-block">
                                <div class="col-sm-6" style="display:inline-block;">
                                    Valor Atual
                                    <input style="float: left" type="number" class="form-control input-lg" id="valorAtual" name="valorAtual"
                                           value="{{isset($c->valor) ? $c->valor : '0,00'}}">
                                </div>
                                <div class="col-sm-6" style="display:inline-block;">
                                    Novo Valor
                                    <input style="float: right" type="number" class="form-control input-lg" id="novoValor{{$c->tamanho}}" name="novoValor{{$c->tamanho}}"
                                           value="{{isset($c->valor) ? $c->valor : '0,00'}}">
                                </div>
                                <input type="hidden" name="codigo{{$c->tamanho}}" value="{{$c->codigo}}">


                            </div>

                        @endforeach
                            <div class="col-sm-11 right">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                {{--<a href="{{route('funcionario.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">--}}
                                    {{--Voltar--}}
                                {{--</a>--}}
                            </div>
                        </form>

                        {{--<table class="table table-bordered table-striped" id="tabcategorias">--}}
                            {{--<thead>--}}
                                {{--<tr align="center">--}}
                                    {{--<td class="col-md-4"><strong>Descrição</strong></td>--}}
                                    {{--<td class="col-md-4" align="center"><strong>Ações</strong></td>--}}
                                {{--</tr>--}}
                            {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($categoria as $c)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$c->tamanho}}</td>--}}
                                        {{--<td align="right">--}}
                                            {{--<a href="{{route('categoria.show',$c->codigo)}}" class="btn btn-small btn-info">--}}
                                                {{--<i class="fa fa-search-plus"></i>--}}
                                                {{--Detalhes--}}
                                            {{--</a>--}}
                                            {{--<a href="{{route('categoria.edit',$c->codigo)}}" class="btn btn-small btn-default" style="background-color: goldenrod;color: white">--}}
                                                {{--<i class="fa fa-pencil-square-o"></i>--}}
                                                {{--Editar--}}
                                            {{--</a>--}}
                                            {{--<a data-toggle="modal" href="#myModal{{$c->codigo}}" class="btn btn-small btn-danger">--}}
                                                {{--<i class="fa fa-trash-o"></i>--}}
                                                {{--Excluir--}}
                                            {{--</a>--}}
                                            {{--<div class="modal fade modal-danger" id="myModal{{$c->codigo}}" role="dialog">--}}
                                                {{--<div class="modal-dialog">--}}
                                                    {{--<div class="modal-content">--}}

                                                        {{--<div class="modal-header" style="text-align: left">--}}
                                                            {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                                            {{--<h4 class="modal-title"> Excluir Categoria </h4>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="modal-body text-center">--}}
                                                            {{--<p>Deseja realmente excluir a categoria {{$c->tamanho}}?</p>--}}
                                                        {{--</div>--}}

                                                        {{--<div class="modal-footer">--}}
                                                            {{--{!! Form::open(array('route' => array('categoria.destroy', $c->codigo), 'method' => 'delete')) !!}--}}
                                                            {{--{!! csrf_field() !!}--}}
                                                            {{--<button class="btn btn-danger" type="submit">Excluir</button>--}}
                                                            {{--<button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>--}}
                                                            {{--{!! Form::close() !!}--}}
                                                        {{--</div>--}}

                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}

                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}

                        {{--</table>--}}

                    </div>

                </div>
        </div>

    </div>
@endsection
@section('scriptlocal')
    <script type="text/javascript">
      $(document).ready(function () {
          $("input[name='valorAtual']").each(function(){
              $(this).attr('disabled', 'disabled');
          });
//          $('#salvar').click(function () {
//
//          });
      });
    </script>
@endsection