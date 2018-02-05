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

                        <form class="form-horizontal" action="{{route('pedido.update', $pedido->codigo)}}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}


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
                                                   value="{{sizeof($marmitasGrandes)}}" placeholder="Qtd Marmita Grande">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputQtdPequena" id="labelPequena" class="col-sm-2 control-label">Pequena</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control input-lg" id="inputQtdPequena" name="qtdPequena"
                                                   value="{{sizeof($marmitasPequenas)}}" placeholder="Qtd Marmita Pequena">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="containerGrande" style="padding-top: 4%"></div>
                            <div id="containerPequena"></div>

                            <div class="form-group" style="margin-bottom: 4%">
                                <div class="text-center">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="checkBebidas" name="checkAddBebidas"> Deseja adicionar bebidas a este pedido?
                                    </label>
                                </div>
                            </div>
                            <div id="divBebidas" class="form-group" style="border-style: groove; margin: auto; padding: 1%">
                                @foreach($bebidas as $key=>$bebida)
                                    <div class="form-inline text-center">
                                        <div>
                                            <label for="labelBebidas">{{$bebida['descricao']}} - {{$bebida['quantidade']}}</label>
                                        </div>

                                        <div>
                                            <input type="number" class="form-control input-sm margin" name="{{$bebida['codigo']}}-B"
                                                   value="0" placeholder="Quantidade">
                                        </div>

                                    </div>
                                @endforeach
                            </div>


                            <div class="form-group" style="padding-top: 3%">
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

                                <div class="form-group form-inline col-md-12">
                                    <div class="form-group col-md-8">
                                        <label for="inputValorTotal" class="col-sm-3 control-label">Valor Total</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="inputValorTotal" name="valorTotal"
                                                   value="{{old('valorTotal')}}" placeholder="Valor Total" disabled="disabled">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="col-md-4">
                                                <a id="buttonValorTotal" class="btn btn-default">Calcular</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="inputTroco" class="col-sm-2 control-label">Troco</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input-lg" id="inputTroco" name="troco"
                                               value="{{$pedido->troco}}" placeholder="Troco">
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
                                           value="{{$pedido->logradouro}}" placeholder="Logradouro">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputBairro" id="labelBairro" class="col-sm-2 control-label">Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" id="inputBairro" name="bairro"
                                           value="{{$pedido->bairro}}" placeholder="Bairro">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputNumero" id="labelNumero" class="col-sm-2 control-label">Número</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputNumero" name="numero"
                                           value="{{$pedido->numero}}" placeholder="Número">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputQuadra" id="labelQuadra" class="col-sm-2 control-label">Quadra</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputQuadra" name="quadra"
                                           value="{{$pedido->quadra}}" placeholder="Quadra">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputLote" id="labelLote" class="col-sm-2 control-label">Lote</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input-lg" id="inputLote" name="lote"
                                           value="{{$pedido->lote}}" placeholder="Lote">
                                </div>
                            </div>
                            </div>
                            <input type="hidden" id="coordenadas" name="coordenadas">

                            <div class="form-group" id="divRetirada">
                                <label for="idOpcao" class="control-label col-sm-2">Horário</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="horas" id="horas">
                                        @for($i=0;$i<=23;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}"{{$i == $horas ? 'selected' : ''}}>{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-1 text-center" style="width: 2px; padding: 1px;">
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="minutos" id="minutos">
                                        @for($i=0;$i<=59;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}" {{$i == $minutos ? 'selected' : ''}}>{{$i<10 ? "0".$i : $i}}</option>
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

            if($('#inputQtdGrande').val() === '0'){
                $('#inputQtdGrande').attr('disabled', 'disabled');
            }else{
                $('#checkG').attr('checked', 'checked');
            }
            if($('#inputQtdPequena').val() === '0'){
                $('#inputQtdPequena').attr('disabled', 'disabled');
            }else{
                $('#checkP').attr('checked', 'checked');
            }
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




            var typingTimer;                //timer identifier
            var doneTypingInterval = 500;  //time in ms, 5 second for example
            var $inputG = $('#inputQtdGrande');
            var $inputP = $('#inputQtdPequena');


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
            var pag = $('#pagamento').find(":selected").text().toLowerCase();
            if(pag !== 'dinheiro'){
                $('#inputTroco').val('');
                $('#inputTroco').attr('disabled', 'disabled');
            }
            $('#pagamento').on('change',function () {
                var pag = $('#pagamento').find(":selected").text().toLowerCase();
                if(pag !== 'dinheiro'){
                    $('#inputTroco').val('');
                    $('#inputTroco').attr('disabled', 'disabled');
                }else{
                    $('#inputTroco').removeAttr('disabled');
                }
            });

            $('#buttonValorTotal').click(function () {
                valorTotal();
            });
            function valorTotal(){
                var catGrande = '<?php echo $categoriaGrande->valor?>';
                var catPequena = '<?php echo $categoriaPequena->valor?>';
                var qtdPequena = $('#inputQtdPequena').val();
                var qtdGrande = $('#inputQtdGrande').val();
                var total = 0;
                if(qtdPequena === "" && qtdGrande === ""){
                    total = 0;
                }else {
                    if (isNaN(parseInt(qtdPequena))) {
                        total = parseInt(qtdGrande) * catGrande;
                    } else {
                        if (isNaN(parseInt(qtdGrande))) {
                            total = parseInt(qtdPequena) * catPequena;
                        } else {
                            total = (parseInt(qtdGrande) * catGrande) + (parseInt(qtdPequena) * catPequena);
                        }
                    }
                }
                if($('#checkBebidas').is(':checked')) {
//                    var qtd = $('#divBebidas input[type = number]').length;
//                    for(y=0;y<qtd;y++){
//                       alert($('#divBebidas input[type = number]').attr('name'));
//                    }
                    var result = 0;

                    $('#divBebidas').find('input[name][value]').each(function(){
                        if($(this).val() != ''){
                            var res = $(this).attr('name').split("");
                            //alert(res[0]);
                            var qtd = $(this).val();
                            $.ajax({
                                url: '../../valorBebida/' + res[0],
                                type: 'GET',
                                dataType: 'json',
                                success: function (obj) {
                                    result += parseFloat(obj.valor)*parseFloat(qtd);
                                    //alert(result);
                                },
                                async: false
                            });

                        }
                    });
                    //alert(result);
                    total = total + result;
                }
                $('#inputValorTotal').attr('value', total);
            }

            if($inputG!==0){
                preencherItensG();
            }
            if($inputP!==0){
                preencherItensP();
            }
            function preencherItensG2 (valorPadrao) {

                var itens = '<?php echo $itens ?>';
                var marmitas = '<?php echo $marmitasGrandes ?>';
                var mg = JSON.parse(marmitas);
                //alert(mg[0].codigo);


                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                var z = 0;

                for (i = 0; i <  valorPadrao; i++) {
//                    console.log("i preencher "+i);
                    var htmlOne = "<div class='panel-group col-md-12' id='accordion"+i+"'>"
                        +"<div class='panel panel-default'><div class='panel-heading text-center bg-navy'>"
                        +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse"+i+"'>"
                        +"Marmita Grande "+(i+1)+" </a></h4>"
                        +"<input type='hidden' name='"+(i+1)+"C' value='"+mg[i].codigo+"'></div>"
                        +"<div id='collapse"+i+"' class='panel-collapse collapse'>"
                        +"<div class='panel-body' id='div"+i+"'>";
                    $.each(JSON.parse(itens), function (j, obj) {
                        htmlTwo += "<div class='form-check checkbox-inline'>"
                            + "<input type='checkbox' name= '"+i+j+"G' class='form-check-input' id='inputItem' value='" + obj.codigo + "'>" +
                            "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                            + "</div>";
                    });

                    $('#containerGrande').append(htmlOne+htmlTwo+htmlThree);
                    //console.log("i - "+i);
                    $.ajax({
                        url:'../../../itensMarmitas/'+mg[i].codigo,
                        type:'GET',
                        dataType:'json',
                        success: function(result){

                            $.each(JSON.parse(result), function (x, objItemMarmita) {
                                //console.log(objItemMarmita.cod_item);
                                //console.log("#div"+z);
                                $("#div"+z).find("input[type=checkbox][value="+objItemMarmita.cod_item+"]").prop("checked","true");
                            });
                            z++;
                        }
                    });
                    htmlTwo = "";
                }
            }

            function preencherItensG () {

                var itens = '<?php echo $itens ?>';
                var marmitas = '<?php echo $marmitasGrandes ?>';
                var mg = JSON.parse(marmitas);
                //alert(mg[0].codigo);


                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                var z = 0;

                for (i = 0; i <  $('#inputQtdGrande').val(); i++) {
//                    console.log("i preencher "+i);
                    var htmlOne = "<div class='panel-group col-md-12' id='accordion"+i+"'>"
                        +"<div class='panel panel-default'><div class='panel-heading text-center bg-navy'>"
                        +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse"+i+"'>"
                        +"Marmita Grande "+(i+1)+" </a></h4>"
                        +"<input type='hidden' name='"+(i+1)+"C' value='"+mg[i].codigo+"'></div>"
                        +"<div id='collapse"+i+"' class='panel-collapse collapse'>"
                        +"<div class='panel-body' id='div"+i+"'>";
                    $.each(JSON.parse(itens), function (j, obj) {
                        htmlTwo += "<div class='form-check checkbox-inline'>"
                            + "<input type='checkbox' name= '"+i+j+"G' class='form-check-input' id='inputItem' value='" + obj.codigo + "'>" +
                            "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                            + "</div>";
                    });

                    $('#containerGrande').append(htmlOne+htmlTwo+htmlThree);
                    //console.log("i - "+i);
                    $.ajax({
                        url:'../../../itensMarmitas/'+mg[i].codigo,
                        type:'GET',
                        dataType:'json',
                        success: function(result){

                            $.each(JSON.parse(result), function (x, objItemMarmita) {
                                //console.log(objItemMarmita.cod_item);
                                //console.log("#div"+z);
                                $("#div"+z).find("input[type=checkbox][value="+objItemMarmita.cod_item+"]").prop("checked","true");
                            });
                            z++;
                        }
                    });
                    htmlTwo = "";
                }
            }

            //user is "finished typing," do something
            function doneTypingG () {

//                console.log("ultima "+$('#containerGrande').children().last().attr('id'));
                var valorAtual = $('#containerGrande .panel-group').length;

                //console.log("valor Atual "+element);
               var lastDiv = $('#containerGrande').children().last().attr('id');
               if(lastDiv === undefined){
                   r=-1;
               }else{
                   var r = lastDiv.replace('accordion', '');
                   //console.log("ultima "+r);
               }

                var itens = '<?php echo $itens ?>';

                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                var cont = 0;
                var verificador = 0;

                var valorPadrao = $('#inputQtdGrande').prop('defaultValue');
                var flagPadrao = 0;

                if($('#inputQtdGrande').val() > valorAtual){
                    if(valorAtual < valorPadrao){
                        $('#containerGrande').empty();
                        preencherItensG2(valorPadrao);
                        r++;
                        cont = $('#inputQtdGrande').val() - valorAtual;
                        cont--;
                    }else{

                        cont = $('#inputQtdGrande').val() - valorAtual;
                    }
                    //r++;
                    //console.log("cont "+cont);
                }else{
                    if(valorAtual > $('#inputQtdGrande').val()){
                        cont = valorAtual - $('#inputQtdGrande').val();
                        verificador = 1;
                    }
                }
                if($('#inputQtdGrande').val() <= valorPadrao){
                    $('#containerGrande').empty();
                    preencherItensG();
                    flagPadrao = 1;
                }
                if(verificador === 0 && flagPadrao === 0){
                    for (i = 0; i < cont; i++) {
                        r++;
                        var htmlOne = "<div class='panel-group col-md-12' id='accordion"+r+"'>"
                            +"<div class='panel panel-default'><div class='panel-heading text-center bg-navy'>"
                            +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse"+r+"'>"
                            +"Marmita Grande "+(r+1)+" </a></h4>"
                            +"<input type='hidden' name='"+(r+1)+"C' value='"+0+"'></div>"
                            +"</div><div id='collapse"+r+"' class='panel-collapse collapse'>"
                            +"<div class='panel-body'>";
                        $.each(JSON.parse(itens), function (j, obj) {
                            htmlTwo += "<div class='form-check checkbox-inline'>"
                                + "<input type='checkbox' name= '"+r+j+"G' checked='checked' class='form-check-input' id='inputItem' value='" + obj.codigo + "'>" +
                                "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                                + "</div>";
                        });

                        $('#containerGrande').append(htmlOne+htmlTwo+htmlThree);
                        htmlTwo = "";
                    }
                }
                if(verificador === 1){
                    var contador = r;
                    for (i = 0; i < cont; i++) {
                        //console.log('i '+i);
                        //console.log($('#containerGrande').find('#accordion'+contador).attr('id'));
                        $('#containerGrande').find('#accordion'+contador).remove();
                        contador--;
                    }

                }

            }

            //---------------------------------------MARMITAS PEQUENAS -------------------------------------------


            function preencherItensP () {

                var itens = '<?php echo $itens ?>';
                var marmitas = '<?php echo $marmitasPequenas ?>';
                var mg = JSON.parse(marmitas);
                //alert(mg[0].codigo);


                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                var z = 0;

                for (i = 0; i <  $('#inputQtdPequena').val(); i++) {
//                    console.log("i preencher "+i);
                    var htmlOne = "<div class='panel-group col-md-12' id='accordionP"+i+"'>"
                        +"<div class='panel panel-default'><div class='panel-heading text-center bg-olive'>"
                        +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordionP' href='#collapseP"+i+"'>"
                        +"Marmita Pequena "+(i+1)+" </a></h4>"
                        +"<input type='hidden' name='"+(i+1)+"D' value='"+mg[i].codigo+"'></div>"
                        +"<div id='collapseP"+i+"' class='panel-collapse collapse'>"
                        +"<div class='panel-body' id='divP"+i+"'>";
                    $.each(JSON.parse(itens), function (j, obj) {
                        htmlTwo += "<div class='form-check checkbox-inline'>"
                            + "<input type='checkbox' name= '"+i+j+"P' class='form-check-input' id='inputItem' value='" + obj.codigo + "'>" +
                            "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                            + "</div>";
                    });

                    $('#containerPequena').append(htmlOne+htmlTwo+htmlThree);
                    //console.log("i - "+i);
                    $.ajax({
                        url:'../../../itensMarmitasPequenas/'+mg[i].codigo,
                        type:'GET',
                        dataType:'json',
                        success: function(result){

                            $.each(JSON.parse(result), function (x, objItemMarmita) {
                                //console.log(objItemMarmita.cod_item);
                                //console.log("#div"+z);
                                $("#divP"+z).find("input[type=checkbox][value="+objItemMarmita.cod_item+"]").prop("checked","true");
                            });
                            z++;
                        }
                    });
                    htmlTwo = "";
                }
            }
            function preencherItensP2 (valorPadrao) {

                var itens = '<?php echo $itens ?>';
                var marmitas = '<?php echo $marmitasPequenas ?>';
                var mg = JSON.parse(marmitas);
                //alert(mg[0].codigo);


                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                var z = 0;

                for (i = 0; i <  valorPadrao; i++) {
//                    console.log("i preencher "+i);
                    var htmlOne = "<div class='panel-group col-md-12' id='accordionP"+i+"'>"
                        +"<div class='panel panel-default'><div class='panel-heading text-center bg-olive'>"
                        +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordionP' href='#collapseP"+i+"'>"
                        +"Marmita Pequena "+(i+1)+" </a></h4>"
                        +"<input type='hidden' name='"+(i+1)+"D' value='"+mg[i].codigo+"'></div>"
                        +"<div id='collapseP"+i+"' class='panel-collapse collapse'>"
                        +"<div class='panel-body' id='divP"+i+"'>";
                    $.each(JSON.parse(itens), function (j, obj) {
                        htmlTwo += "<div class='form-check checkbox-inline'>"
                            + "<input type='checkbox' name= '"+i+j+"P' class='form-check-input' id='inputItem' value='" + obj.codigo + "'>" +
                            "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                            + "</div>";
                    });

                    $('#containerPequena').append(htmlOne+htmlTwo+htmlThree);
                    //console.log("i - "+i);
                    $.ajax({
                        url:'../../../itensMarmitasPequenas/'+mg[i].codigo,
                        type:'GET',
                        dataType:'json',
                        success: function(result){

                            $.each(JSON.parse(result), function (x, objItemMarmita) {
                                //console.log(objItemMarmita.cod_item);
                                //console.log("#div"+z);
                                $("#divP"+z).find("input[type=checkbox][value="+objItemMarmita.cod_item+"]").prop("checked","true");
                            });
                            z++;
                        }
                    });
                    htmlTwo = "";
                }
            }

            function doneTypingP () {

//                console.log("ultima "+$('#containerGrande').children().last().attr('id'));
                var valorAtual = $('#containerPequena .panel-group').length;

                //console.log("valor Atual "+element);
                var lastDiv = $('#containerPequena').children().last().attr('id');
                if(lastDiv === undefined){
                    r=-1;
                }else{
                    var r = lastDiv.replace('accordionP', '');
                    //console.log("ultima "+r);
                }

                var itens = '<?php echo $itens ?>';

                var htmlThree = "</div></div></div></div>";
                var htmlTwo = "";

                var cont = 0;
                var verificador = 0;

                var valorPadrao = $('#inputQtdPequena').prop('defaultValue');
                var flagPadrao = 0;

                if($('#inputQtdPequena').val() > valorAtual){
                    if(valorAtual < valorPadrao){
                        $('#containerPequena').empty();
                        preencherItensP2(valorPadrao);
                        r++;
                        cont = $('#inputQtdPequena').val() - valorAtual;
                        cont--;
                    }else{

                        cont = $('#inputQtdPequena').val() - valorAtual;
                    }
                    //r++;
                    //console.log("cont "+cont);
                }else{
                    if(valorAtual > $('#inputQtdPequena').val()){
                        cont = valorAtual - $('#inputQtdPequena').val();
                        verificador = 1;
                    }
                }
                if($('#inputQtdPequena').val() <= valorPadrao){
                    $('#containerPequena').empty();
                    preencherItensP();
                    flagPadrao = 1;
                }
                if(verificador === 0 && flagPadrao === 0){
                    for (i = 0; i < cont; i++) {
                        r++;
                        var htmlOne = "<div class='panel-group col-md-12' id='accordionP"+r+"'>"
                            +"<div class='panel panel-default'><div class='panel-heading text-center bg-olive'>"
                            +"<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordionP' href='#collapseP"+r+"'>"
                            +"Marmita Pequena "+(r+1)+" </a></h4>"
                            +"<input type='hidden' name='"+(r+1)+"D' value='"+0+"'></div>"
                            +"</div><div id='collapseP"+r+"' class='panel-collapse collapse'>"
                            +"<div class='panel-body'>";
                        $.each(JSON.parse(itens), function (j, obj) {
                            htmlTwo += "<div class='form-check checkbox-inline'>"
                                + "<input type='checkbox' name= '"+r+j+"P' checked='checked' class='form-check-input' id='inputItemP' value='" + obj.codigo + "'>" +
                                "<label class='form-check-label' for='labelItem'>" + obj.descricao + "</label>"
                                + "</div>";
                        });

                        $('#containerPequena').append(htmlOne+htmlTwo+htmlThree);
                        htmlTwo = "";
                    }
                }
                if(verificador === 1){
                    var contador = r;
                    for (i = 0; i < cont; i++) {
                        //console.log('i '+i);
                        //console.log($('#containerGrande').find('#accordion'+contador).attr('id'));
                        $('#containerPequena').find('#accordionP'+contador).remove();
                        contador--;
                    }

                }

            }

            var d = '<?php echo $bebidasPedido ?>';
            var drinks = JSON.parse(d);
            var inputsDrinks = $('#divBebidas .form-inline :input');
            var testar = 0;

           for(x=0;x<inputsDrinks.length;x++){

               if (drinks[x] !== undefined) {
                   $("input[name="+drinks[x].cod_bebida+"-B]").attr('value',drinks[x].qtd);
                    testar = 1;
               }
           }
           if(testar === 1){
               $("#checkBebidas").attr('checked','checked');
               $('#divBebidas').show();
           }else{
               $('#checkBebidas').removeAttr('checked');
               $('#divBebidas').hide();
           }
            $("#checkBebidas").click(function(){
                if($('#checkBebidas').is(':checked')){
                    $('#divBebidas').show();
                }else{
                    $('#divBebidas').hide();
                    $('#divBebidas input[type = number]').val("");
                }
            });

            $('#divEntrega').hide();
            $('#divRetirada').hide();

            $.ajax({
                url:'../../enderecoPedido/'+$('#cliente').val(),
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
                        url:'../../enderecoPedido/'+$('#cliente').val(),
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