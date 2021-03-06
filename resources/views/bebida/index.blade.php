@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Bebidas
@endsection

@section('contentheader_title')
    Bebidas
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

                        <a href="{{route('bebida.create')}}" class="btn btn-small btn-primary col-md-12">
                            <i class="fa fa-plus-circle"></i>
                            Novo
                        </a>
                    </div>

                    <div class="box-body">

                        <table class="table table-bordered table-striped" id="tabbebidas">
                            <thead>
                                <tr align="center">
                                    <td class="col-md-4"><strong>Descrição</strong></td>
                                    <td class="col-md-4" align="center"><strong>Ações</strong></td>
                                </tr>
                            </thead>
                                <tbody>
                                @foreach($bebida as $c)
                                    <tr>
                                        <td>{{$c->descricao}}</td>
                                        <td align="right">
                                            <a href="{{route('bebida.show',$c->codigo)}}" class="btn btn-small btn-info">
                                                <i class="fa fa-search-plus"></i>
                                                Detalhes
                                            </a>
                                            <a href="{{route('bebida.edit',$c->codigo)}}" class="btn btn-small btn-default" style="background-color: goldenrod;color: white">
                                                <i class="fa fa-pencil-square-o"></i>
                                                Editar
                                            </a>
                                            <a data-toggle="modal" href="#myModal{{$c->codigo}}" class="btn btn-small btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                                Excluir
                                            </a>
                                            <div class="modal fade modal-danger" id="myModal{{$c->codigo}}" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-header" style="text-align: left">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title"> Excluir bebida </h4>
                                                        </div>

                                                        <div class="modal-body text-center">
                                                            <p>Deseja realmente excluir a bebida {{$c->descricao}}?</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            {!! Form::open(array('route' => array('bebida.destroy', $c->codigo), 'method' => 'delete')) !!}
                                                            {!! csrf_field() !!}
                                                            <button class="btn btn-danger" type="submit">Excluir</button>
                                                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                            {!! Form::close() !!}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>

                        </table>

                    </div>

                </div>
        </div>

    </div>
@endsection
@section('scriptlocal')
    <script type="text/javascript">
      $(document).ready(function () {
        $('#tabbebidas').DataTable( {
          "language": {
            "paginate": {
              "previous": "Anterior",
              "next": "Próxima"
            },
            "sSearch": "<span>Pesquisar</span> _INPUT_", //search
            "lengthMenu": "Exibir _MENU_ registros por página",
            "zeroRecords": "Não há resultados para esta busca",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(Filtrado de _MAX_ registros)"

          }
        } );
      })
    </script>
@endsection