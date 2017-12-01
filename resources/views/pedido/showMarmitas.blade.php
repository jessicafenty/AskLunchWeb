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
{{--                        <h2 class="box-title">{{$marmitas->nome}}</h2>--}}
                    </div>

                    <div class="box-body">

                        <div class="jumbotron">

                            <h3 style="background-color: white; text-align: center">Marmitas</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large" id="marmitas">
                                @foreach($marmitas as $m)
                                    <a href="#" name="option" id="{{$m->cod_marmita}}">{{$m->cod_marmita ." - ". $m->tamanho}}</a><br>
                                @endforeach
                            </div>
                            <h3 style="background-color: white; text-align: center">Itens da Marmita</h3>
                            <div style="border-style: solid; padding: 5px;border-color: white; font-size: large" id="itens">
                                {{--<strong>Teste</strong><br>--}}
                            </div>

                        </div>
                        <a href="{{route('pedido.recebido')}}" class="btn btn-small btn-primary pull-right btn-lg" style="float: right">
                            Voltar
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
@section('scriptlocal')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#itens').hide();
//          $('#marmitas').click(function(){
//              $('#itens').show();
//          });
            $('a[name="option"]').click(function() {
                $('#itens').show();
                //alert($(this).attr('id'));
                $.ajax({
                    url: '../../itens/' + $(this).attr('id'),
                    type: 'GET',
                    dataType: 'json',
                    success: function (json) {
                        $('#itens').empty();
                        $.each(JSON.parse(json), function (i, obj) {
                            $('#itens').append(obj.descricao.concat("<br>"));
                        })
                    }
                });
            });

        });
    </script>
@endsection