@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Cadastrar Pedido
@endsection

@section('contentheader_title')
    Cadastrar Pedido
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
            <div class="box danger alert-danger">
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

                        <form class="form-horizontal" action="{{action('PedidoController@store')}}" method="post">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">

                            <div class="form-group text-center" style="border-style: groove; margin: auto">
                                <h4>Selecione o tamanho da marmita e informe a quantidade</h4>


                            <div class="form-group text-center">
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="checkG">Grande
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="checkP">Pequena
                                    </label>
                                </div>

                            </div>

                            <div class="form-group form-inline text-center">
                                <div class="form-group">
                                    <label for="inputQtdGrande" id="labelGrande" class="col-sm-2 control-label">Grande</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-lg" id="inputQtdGrande" name="qtdGrande"
                                               value="{{old('qtdGrande')}}" placeholder="Qtd Marmita Grande">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputQtdPequena" id="labelPequena" class="col-sm-2 control-label">Pequena</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-lg" id="inputQtdPequena" name="qtdPequena"
                                               value="{{old('qtdPequena')}}" placeholder="Qtd Marmita Pequena">
                                    </div>
                                </div>
                            </div>
                            </div>


                            {{--<div class="panel-group col-md-12" id="accordion">--}}
                                {{--<div class="panel panel-default">--}}
                                    {{--<div class="panel-heading text-center">--}}
                                        {{--<h4 class="panel-title">--}}
                                            {{--<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Marmita</a>--}}
                                        {{--</h4>--}}
                                    {{--</div>--}}
                                    {{--<div id="collapse1" class="panel-collapse collapse">--}}
                                        {{--<div class="panel-body">--}}
                                            {{--@foreach($itens as $item)--}}
                                                {{--<div class="form-check checkbox-inline">--}}
                                                    {{--<input type="checkbox" checked="checked" class="form-check-input" id="inputItem" value="{{$item['codigo']}}">--}}
                                                    {{--<label class="form-check-label" for="labelItem">{{$item['descricao']}}</label>--}}
                                                {{--</div>--}}
                                            {{--@endforeach--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div id="containerGrande" style="padding-top: 3%"></div>
                            <div id="containerPequena"></div>



                                <div class="form-group">
                                    <label for="idPagamento" class="control-label col-sm-2">
                                        <a href="{{route('formapagamento.create')}}">Pagamento</a>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="pagamento" id="pagamento">
                                            @foreach($formapagamento as $value)
                                                <option value="{{$value['codigo']}}" {{ $value['codigo'] === (isset($pedido->cod_forma_pagamento) ? $pedido->cod_forma_pagamento : '' ) ? 'selected' : '' }}>{{$value['descricao']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputTroco" class="col-sm-2 control-label">Troco</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input-lg" id="inputTroco" name="troco"
                                               value="{{old('troco')}}" placeholder="Troco">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="idCliente" class="control-label col-sm-2">
                                        <a href="{{route('funcionario.create')}}">Cliente</a>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="cliente" id="cliente">
                                            @foreach($cliente as $value)
                                                <option value="{{$value['codigo']}}" {{ $value['codigo'] === (isset($pedido->cod_cliente) ? $pedido->cod_cliente : '' ) ? 'selected' : '' }}>{{$value['nome']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="idOpcao" class="control-label col-sm-2">Opção</label>
                                    <div class="col-md-10">
                                        <a id="entrega" class="btn btn-default">Entrega</a>
                                        <a id="retirada" class="btn btn-default">Retirada</a>
                                        <input type="hidden" id="codigo" name="codigo">
                                    </div>
                                </div>
                            <div id="divEntrega">
                            <div class="form-group">
                                <label for="inputLogradouro" id="labelLogradouro" class="col-sm-2 control-label">Logradouro</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" id="inputLogradouro" name="logradouro"
                                           value="{{old('logradouro')}}" placeholder="Logradouro">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputBairro" id="labelBairro" class="col-sm-2 control-label">Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" id="inputBairro" name="bairro"
                                           value="{{old('bairro')}}" placeholder="Bairro">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputNumero" id="labelNumero" class="col-sm-2 control-label">Número</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputNumero" name="numero"
                                           value="{{old('numero')}}" placeholder="Número">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputQuadra" id="labelQuadra" class="col-sm-2 control-label">Quadra</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputQuadra" name="quadra"
                                           value="{{old('quadra')}}" placeholder="Quadra">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputLote" id="labelLote" class="col-sm-2 control-label">Lote</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputLote" name="lote"
                                           value="{{old('lote')}}" placeholder="Lote">
                                </div>
                            </div>
                            </div>
                            <input type="hidden" id="coordenadas" name="coordenadas">

                            <div class="form-group" id="divRetirada">
                                <label for="idOpcao" class="control-label col-sm-2">Horário</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="horas" id="horas">
                                        @for($i=0;$i<=23;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}">{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-1 text-center" style="width: 2px; padding: 1px;">
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="minutos" id="minutos">
                                        @for($i=0;$i<=59;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}">{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>



                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                <a href="{{route('pedido.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">
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
@section('scriptlocal')
    <script type="text/javascript">
        $(document).ready(function () {

            var typingTimer;                //timer identifier
            var doneTypingInterval = 500;  //time in ms, 5 second for example
            var $inputG = $('#inputQtdGrande');
            var $inputP = $('#inputQtdPequena');

            //on keyup, start the countdown
            $inputG.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTypingG, doneTypingInterval);
            });

            //on keydown, clear the countdown
            $inputG.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            //on keyup, start the countdown
            $inputP.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTypingP, doneTypingInterval);
            });

            //on keydown, clear the countdown
            $inputP.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            //user is "finished typing," do something
            function doneTypingG () {

                var itens = '<?php echo $itens ?>';

                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                for (i = 0; i < $('#inputQtdGrande').val(); i++) {
                    var htmlOne = "<div class='panel-group col-md-12' id='accordion"+i+"'>"
                        +"<div class='panel panel-default'><div class='panel-heading text-center bg-navy'>"
                        +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse"+i+"'>"
                        +"Marmita Grande "+(i+1)+" </a></h4></div><div id='collapse"+i+"' class='panel-collapse collapse'>"
                        +"<div class='panel-body'>";
                    $.each(JSON.parse(itens), function (j, obj) {
                        htmlTwo += "<div class='form-check checkbox-inline'>"
                            + "<input type='checkbox' name= '"+i+j+"G' checked='checked' class='form-check-input' id='inputItem' value='" + obj.codigo + "'>" +
                            "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                            + "</div>";
                    });

                        $('#containerGrande').append(htmlOne+htmlTwo+htmlThree);
                        htmlTwo = "";
                }
            }
            function doneTypingP () {

                var itens = '<?php echo $itens ?>';

                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                for (i = 0; i < $('#inputQtdPequena').val(); i++) {
                    var htmlOne = "<div class='panel-group col-md-12' id='accordionP"+i+"'>"
                        +"<div class='panel panel-default'><div class='panel-heading text-center bg-olive'>"
                        +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordionP' href='#collapseP"+i+"'>"
                        +"Marmita Pequena "+(i+1)+" </a></h4></div><div id='collapseP"+i+"' class='panel-collapse collapse'>"
                        +"<div class='panel-body'>";
                    $.each(JSON.parse(itens), function (j, obj) {
                        htmlTwo += "<div class='form-check checkbox-inline'>"
                            + "<input type='checkbox' name= '"+i+j+"P' checked='checked' class='form-check-input' id='inputItemP' value='" + obj.codigo + "'>" +
                            "<label class='form-check-label' for='labelItemP'>" + obj.descricao + "</label>"
                            + "</div>";
                    });

                    $('#containerPequena').append(htmlOne+htmlTwo+htmlThree);
                    htmlTwo = "";
                }
            }




            $('#inputQtdGrande').attr('disabled', 'disabled');
            $('#inputQtdPequena').attr('disabled', 'disabled');
            $("#checkG").click(function(){
                if($('#checkG').is(':checked')){
                    $('#inputQtdGrande').removeAttr('disabled');
                }else{
                    $('#inputQtdGrande').attr('disabled', 'disabled');
                }
            });
            $("#checkP").click(function(){
                if($('#checkP').is(':checked')){
                    $('#inputQtdPequena').removeAttr('disabled');
                }else{
                    $('#inputQtdPequena').attr('disabled', 'disabled');
                }
            });
            $('#divEntrega').hide();
            $('#divRetirada').hide();
            $.ajax({
                url:'../../enderecoCliente/'+$('#cliente').val(),
                type:'GET',
                dataType:'json',
                success: function(result){
                    $.each(JSON.parse(result), function (i, obj) {
                        $('#inputLogradouro').attr('value', obj.logradouro);
                        $('#inputBairro').attr('value', obj.bairro);
                        $('#inputNumero').attr('value', obj.numero);
                        $('#inputQuadra').attr('value', obj.quadra);
                        $('#inputLote').attr('value', obj.lote);
                        $('#coordenadas').attr('value', obj.coordenadas);
                    });
                }
            });
            $("#entrega").click(function(){
                $("#cliente").change(function(){
                    $.ajax({
                        url:'../../enderecoCliente/'+$('#cliente').val(),
                        type:'GET',
                        dataType:'json',
                        success: function(result){
                            $.each(JSON.parse(result), function (i, obj) {
                                $('#inputLogradouro').attr('value', obj.logradouro);
                                $('#inputBairro').attr('value', obj.bairro);
                                $('#inputNumero').attr('value', obj.numero);
                                $('#inputQuadra').attr('value', obj.quadra);
                                $('#inputLote').attr('value', obj.lote);
                                $('#coordenadas').attr('value', obj.coordenadas);
                            });
                        }
                    });
                });

                $('#divEntrega').show();
                $('#divRetirada').hide();
                $('#codigo').attr('value', '1');

            });
            $("#retirada").click(function(){
                $('#divRetirada').show();
                $('#divEntrega').hide();
                $('#codigo').attr('value', '0');
            });
        });
    </script>
@endsection