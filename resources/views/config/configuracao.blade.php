@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Configurar Horário de Recebimento de Pedidos
@endsection

@section('contentheader_title')
    Configurar Horário de Recebimento de Pedidos
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="box">

                    <div class="box-body">

                        <form class="form-horizontal" action="{{route('config.save')}}" method="post">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">

                            <div class="form-group">
                                <label for="idOpcao" class="control-label col-sm-2">Horário Inicial</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="horasIni" id="horasIni">
                                        @for($i=0;$i<=23;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}"{{isset($horasIni)? ($i == $horasIni ? 'selected' : '') : ''}}>{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-1 text-center" style="width: 2px; padding: 1px;">
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="minutosIni" id="minutosIni">
                                        @for($i=0;$i<=59;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}" {{isset($minutosIni) ? ($i == $minutosIni ? 'selected' : '') : ''}}>{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="idOpcao" class="control-label col-sm-2">Horário Final</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="horasFim" id="horasFim">
                                        @for($i=0;$i<=23;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}"{{isset($horasFim)? ($i == $horasFim ? 'selected' : '') : ''}}>{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-1 text-center" style="width: 2px; padding: 1px;">
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="minutosFim" id="minutosFim">
                                        @for($i=0;$i<=59;$i++)
                                            <option value="{{$i<10 ? "0".$i : $i}}" {{isset($minutosFim)? ($i == $minutosFim ? 'selected' : '') : ''}}>{{$i<10 ? "0".$i : $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right btn-lg">Salvar</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection