@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Gerenciamento de Pedidos
@endsection

@section('contentheader_title')
    Gerenciamento de Pedidos
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

                    {{--<div class="box-title">--}}
                        {{--<select class="form-control" name="filtro" id="filtro">--}}
                            {{--<option value="Recebido">Recebido</option>--}}
                            {{--<option value="Pronto">Pronto</option>--}}
                            {{--<option value="Em Rota">Em Rota</option>--}}
                            {{--<option value="Finalizado">Finalizado</option>--}}
                            {{--<option value="Cancelado">Cancelado</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}

                    <div class="box-body">



                        <table class="table table-bordered table-striped" id="tabpedidos">
                            <thead>
                                <tr align="center">
                                    <td class="col-md-2" align="center"><strong>Cliente</strong></td>
                                    {{--<td class="col-md-4"><strong>Data</strong></td>--}}
                                    <td class="col-md-2" align="center"><strong>Forma de Pagamento</strong></td>
                                    <td class="col-md-1" align="center"><strong>Troco</strong></td>
                                    <td class="col-md-1" align="center"><strong>Entrega</strong></td>
                                    <td class="col-md-1" align="center"><strong>Horário</strong></td>
                                    {{--<td class="col-md-4" align="center"><strong>Logradouro</strong></td>--}}
                                    {{--<td class="col-md-4" align="center"><strong>Bairro</strong></td>--}}
                                    {{--<td class="col-md-4" align="center"><strong>Número</strong></td>--}}
                                    {{--<td class="col-md-4" align="center"><strong>Quadra</strong></td>--}}
                                    {{--<td class="col-md-4" align="center"><strong>Lote</strong></td>--}}
                                    {{--<td class="col-md-2" align="center"><strong>Status Atual</strong></td>--}}
                                    <td class="col-md-2" align="center"><strong>Status</strong></td>
                                    <td class="col-md-2" align="center"><strong>Entregador</strong></td>
                                    <td class="col-md-2" align="center"><strong>Ações</strong></td>
                                    {{--<td class="col-md-4" align="center"><strong>Coordenadas</strong></td>--}}
                                </tr>
                            </thead>
                                <tbody>
                                @foreach($pedido as $c)
                                    <tr>
                                        {{--<td>{{$c->codigo}}</td>--}}
                                        <td>{{$c->funcionario->nome}}</td>
                                        <td>{{$c->formapagamento->descricao}}</td>
                                        <td align="center">{{$c->troco === '0.00' ? '-' : $c->troco}}</td>
                                        <td align="center">{{$c->entrega === 1 ? 'Sim' : 'Não'}}</td>
                                        <td align="center">{{$c->horario === '00:00:00' ? '-' : $c->horario}}</td>
                                        {{--<td>{{$c->logradouro}}</td>--}}
                                        {{--<td>{{$c->bairro}}</td>--}}
                                        {{--<td>{{$c->numero}}</td>--}}
                                        {{--<td>{{$c->quadra}}</td>--}}
                                        {{--<td>{{$c->lote}}</td>--}}
                                        {{--<td>{{$c->status}}</td>--}}
                                        {{--<td>--}}
                                            {{--<select class="form-control" name="statuspedido" id="{{$c->codigo}}">--}}
                                                {{--<option value="Recebido" {{ "Recebido" === (isset($c->status) ? $c->status : '' ) ? 'selected' : '' }}>Recebido</option>--}}
                                                {{--<option value="Pronto" {{ "Pronto" === (isset($c->status) ? $c->status : '' ) ? 'selected' : '' }}>Pronto</option>--}}
                                                {{--<option value="Em Rota" {{ "Em Rota" === (isset($c->status) ? $c->status : '' ) ? 'selected' : '' }}>Em Rota</option>--}}
                                                {{--<option value="Finalizado" {{ "Finalizado" === (isset($c->status) ? $c->status : '' ) ? 'selected' : '' }}>Finalizado</option>--}}
                                                {{--<option value="Cancelado" {{ "Cancelado" === (isset($c->status) ? $c->status : '' ) ? 'selected' : '' }}>Cancelado</option>--}}
                                            {{--</select>--}}
                                        {{--</td>--}}
                                        <td>{{$c->status}}</td>
                                        <td>{{$c->entregador === 'Padrão' ? '-' : $c->entregador}}</td>
                                        {{--<td>--}}
                                            {{--<select {{$c->entrega === 0 ? 'disabled' : ''}} class="form-control" name="entregador" id="{{$c->codigo}}">--}}
                                                {{--<option selected disabled>---</option>--}}
                                                {{--@foreach($entregador as $e)--}}
                                                    {{--<option value="{{$e->nome}}" {{ $e->nome === (isset($c->entregador) ? $c->entregador : '' ) ? 'selected' : '' }}>{{$e->nome}}</option>--}--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</td>--}}
                                        {{--<td>{{$c->entregador}}</td>--}}
                                        <td align="right">
                                            <a href="{{route('pedido.show',$c->codigo)}}" class="btn btn-small btn-info">
                                                <i class="fa fa-search-plus"></i>
                                                Detalhes
                                            </a>
                                        </td>
                                        {{--<td align="center" id="tdcheck"><input name="status" type="checkbox" id="{{$c->codigo}}" value="Ativo" {{ "Ativo" === (isset($c->status_pedido) ? $c->status_pedido : '' ) ? 'checked' : '' }}></td>--}}

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

          $('#tabpedidos').DataTable( {
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
//          $('select[name="entregador"]').change(function(){
//              $.ajax({
//                  url:'../adicionarEntregador/'+$(this).attr('id')+'/'+$(this).find('option:selected').attr("value"),
//                  type:'GET',
//                  dataType:'json'
//              });
//         });

      });
    </script>
@endsection