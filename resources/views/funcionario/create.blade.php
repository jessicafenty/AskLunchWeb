@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Cadastrar Funcionário
@endsection

@section('contentheader_title')
    Cadastrar Funcionário
@endsection
<style>
    #map {
        height: 65%;
        width: 100%;
        margin: auto;
        text-align: center;
    }
</style>

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

                        <form class="form-horizontal" action="{{action('FuncionarioController@store')}}" method="post">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                            <fieldset>
                                <legend>Dados Pessoais</legend>
                                <div class="form-group">
                                    <label for="inputNome" class="col-sm-2 control-label">Nome</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputNome" name="nome"
                                               value="{{old('nome')}}" placeholder="Nome do Funcionario">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputTelefone" class="col-sm-2 control-label">Telefone</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputTelefone" name="telefone"
                                               value="{{old('telefone')}}" placeholder="Telefone">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputDataNasc" class="col-sm-2 control-label">Data Nascimento</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control input-lg" id="inputDataNasc" name="data_nascimento"
                                               value="{{old('data_nascimento')}}" placeholder="Data de Nascimento">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Endereço</legend>
                                <div class="form-group">
                                    <label for="inputLogradouro" class="col-sm-2 control-label">Logradouro</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputLogradouro" name="logradouro"
                                               value="{{old('logradouro')}}" placeholder="Logradouro">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputBairro" class="col-sm-2 control-label">Bairro</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputBairro" name="bairro"
                                               value="{{old('bairro')}}" placeholder="Bairro">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputNumero" class="col-sm-2 control-label">Número</label>
                                    <div class="col-sm-10">
                                        <input type="number" step="any" min="0" class="form-control input-lg" id="inputNumero" name="numero"
                                               value="{{old('numero')}}" placeholder="Número">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputQuadra" class="col-sm-2 control-label">Quadra</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputQuadra" name="quadra"
                                               value="{{old('quadra')}}" placeholder="Quadra">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputLote" class="col-sm-2 control-label">Lote</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-lg" id="inputLote" name="lote"
                                               value="{{old('lote')}}" placeholder="Lote">
                                    </div>
                                </div>
                                {{--<label for="labelPesquisarEndereco" class="col-sm-2 control-label">Endereco</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<input type="text" class="form-control input-lg" id="inputPesquisarEndereco" name="pesquisarEndereco"--}}
                                           {{--value="Avenida Joaquim Cândido, 187, Centro">--}}
                                {{--</div>--}}
                                {{--<button onclick="searchAddress();">Pesquisar</button>--}}
                                <div class="form-group" id="map"></div>
                                <input type="hidden" value="" id="inputHiddenCoordenadas" name="ihcoordenadas">
                            </fieldset>
                            <fieldset>
                                <legend>Usuário</legend>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">E-mail</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control input-lg" id="inputEmail" name="email"
                                               value="{{old('email')}}" placeholder="E-mail">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputSenha" class="col-sm-2 control-label">Senha</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control input-lg" id="inputSenha" name="senha"
                                               value="{{old('senha')}}" placeholder="Senha">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="idTipo" class="control-label col-sm-2">Tipo</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="tipo" id="tipo">
                                            <option value="Administrador">Administrador</option>
                                            <option value="Padrão">Padrão</option>
                                            <option value="Entregador">Entregador</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                                <a href="{{route('funcionario.index')}}" class="btn btn-small btn-primary pull-left btn-lg" style="float: right">
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
    <script>
        $('input[name="telefone"]').mask('(00)00000-0000');
        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        var $logradouro = $('#inputLogradouro');
        var $bairro = $('#inputBairro');
        var $numero = $('#inputNumero');

//        $('#inputNome').bind('keyup blur',function(){
//            var node = $(this);
//            node.val(node.val().replace(/[^a-z]/g,'') ); }
//        );
        $("#inputNome").on("keydown", function(event){
            // Allow controls such as backspace, tab etc.
            var arr = [8,9,16,17,20,35,36,37,38,39,40,45,46,32];

            // Allow letters
            for(var i = 65; i <= 90; i++){
                arr.push(i);
            }

            // Prevent default if not in array
            if(jQuery.inArray(event.which, arr) === -1){
                event.preventDefault();
            }
        });

        $('#inputEmail').on('focusout', function () {
            $('#inputEmail').val($('#inputEmail').val().toLowerCase());
        });

        $logradouro.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(initMap, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $logradouro.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        $bairro.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(initMap, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $bairro.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        //on keyup, start the countdown
        $numero.on('keyup', function () {
//            if($logradouro.val() !== null
//                && $bairro.val() !== null
//                && $numero.val() !== null){
                clearTimeout(typingTimer);
                typingTimer = setTimeout(initMap, doneTypingInterval);
//            }
        });

        //on keydown, clear the countdown
        $numero.on('keydown', function () {
            clearTimeout(typingTimer);
        });


        function initMap() {

            var restaurante = {lat: -17.887522, lng: -51.714028};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 18,
                center: restaurante
            });
            var marker = new google.maps.Marker({
                position: restaurante,
                map: map,
                draggable: true
            });
            marker.addListener('dragend', function() {
                map.setZoom(18);
                map.setCenter(marker.getPosition());
//                alert(marker.position);
                $('#inputHiddenCoordenadas').attr('value', marker.position);

            });
            var addressInput = $logradouro.val()+','+$bairro.val()+','+$numero.val();

//            var map = document.getElementById('map');

            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({address: addressInput}, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {

                    var myResult = results[0].geometry.location; // referência ao valor LatLng

                    createMarker(myResult, marker, map); // adicionar chamada à função que adiciona o marcador

                    map.setCenter(myResult);

                    map.setZoom(17);

                }
            });
            $('#inputHiddenCoordenadas').attr('value', marker.position);

        }
        function createMarker(latlng, marker, map) {

            // Se o utilizador efetuar outra pesquisa é necessário limpar a variável marker
            if(marker != undefined && marker != ''){
                marker.setMap(null);
                marker = '';
            }

            marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true
            });
            marker.addListener('dragend', function() {
                map.setZoom(18);
                map.setCenter(marker.getPosition());
//                alert(marker.position);
                $('#inputHiddenCoordenadas').attr('value', marker.position);

            });
            $('#inputHiddenCoordenadas').attr('value', marker.position);

            //return marker;

        }
        google.maps.event.addDomListener(window, "load", initMap);

    </script>
@endsection