@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Gerenciamento de Pedidos - Pedidos Prontos
@endsection

@section('contentheader_title')
    Gerenciamento de Pedidos - Pedidos Prontos
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


                    </div>

                    <div class="box-body">



                        <table class="table table-bordered table-striped" id="tabpedidosprontos">
                            <thead>
                                <tr align="center">
                                    <td class="col-md-4" align="center"><strong>Cliente</strong></td>
                                    <td class="col-md-1" align="center"><strong>Entrega</strong></td>
                                    <td class="col-md-1" align="center"><strong>Horário</strong></td>
                                    <td class="col-md-1" align="center"><strong>Status</strong></td>
                                    <td class="col-md-4" align="center"><strong>Ações</strong></td>
                                </tr>
                            </thead>
                                <tbody>
                                @foreach($pedido as $c)
                                    <tr class="center">
                                        <td>{{$c->funcionario->nome}}</td>
                                        <td>{{$c->entrega === 1 ? 'Sim' : 'Não'}}</td>
                                        <td>{{$c->horario === '00:00:00' ? '-' : $c->horario}}</td>
                                        <td>{{$c->status}}</td>
                                        <td align="right">
                                            @if($c->horario === '00:00:00')
                                            <div class="col-md-8">
                                                <select class="form-control" name="entregador" id="{{$c->codigo}}">
                                                    <option selected disabled>Selecione o Entregador</option>
                                                    @foreach($entregador as $e)
                                                        <option value="{{$e->nome}}" {{ $e->nome === (isset($c->entregador) ? $c->entregador : '' ) ? 'selected' : '' }}>{{$e->nome}}</option>--}
                                                    @endforeach
                                                </select>
                                            </div>
                                            @elseif($c->horario !== '00:00:00')
                                                <div class="col-md-8">
                                                    <a href="{{route('pedido.finalizar',$c->codigo)}}" class="form-control btn btn-small btn-success">
                                                        {{--<i class="fa fa-check-circle-o"></i>--}}
                                                        Finalizar
                                                    </a>
                                                </div>
                                            @else
                                            @endif

                                            <div class="col-md-4">
                                                <a href="{{route('pedido.cancelar',$c->codigo)}}" class="btn btn-small btn-danger form-control">
                                                    <i class="fa fa-ban"></i>
                                                    Cancelar
                                                </a>
                                            </div>

                                            {{--<a href="#" class="btn btn-small btn-success">--}}
                                                {{--<i class="fa fa-minus-square"></i>--}}
                                                {{--Finalizar--}}
                                            {{--</a>--}}
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

          $('#tabpedidosprontos').DataTable( {
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
          });
//          $('select[name="statuspedido"]').change(function(){
//              $.ajax({
//                  url:'../alterarStatusPedido/'+$(this).attr('id')+'/'+$(this).find('option:selected').attr("value"),
//                  type:'GET',
//                  dataType:'json'
//              });
//          });
          $('select[name="entregador"]').change(function(){
              $.ajax({
                  url:'../adicionarEntregador/'+$(this).attr('id')+'/'+$(this).find('option:selected').attr("value"),
                  type:'GET',
                  dataType:'json',
                  success: function(result) {
//                      if(result === "no_errors") location.href = jQuery.parseJSON(result);

                      window.location.href = jQuery.parseJSON(result);
                  }
              });
         });

      });
    </script>
@endsection