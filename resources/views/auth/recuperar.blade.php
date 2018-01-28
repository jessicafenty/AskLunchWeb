@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Login
@endsection

<style>
    body {
        background: #eee !important;
    }

    .wrapper {
        margin-top: 80px;
        margin-bottom: 80px;
    }

    .form-signin {
        max-width: 380px;
        padding: 15px 35px 45px;
        margin: 0 auto;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    p {
        text-align: center;
    }
    .form-signin .botaoEntrar {
        margin-top: 25px;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 20px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .mensagemErro{
        color: red;
    }
</style>

@section('content')

<div class="wrapper">

    <form class="form-signin" action="{{route('auth.enviar.email')}}" method="post">
        @if (Session::get('mensagem'))
            <div>
                <div class="box danger alert-danger">
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
            {{--@if (Session::get('mensagemOK'))--}}
                {{--<div>--}}
                    {{--<div class="box success alert-success">--}}
                        {{--<div class="box-header with-border">--}}
                            {{--<h3 class="box-title" style="color:white">{{Session::get('mensagem')}}</h3>--}}
                            {{--<div class="box-tools pull-right">--}}
                                {{--<button type="button" class="btn btn-box-tool"--}}
                                        {{--data-widget="remove" data-toggle="tooltip" title="Fechar">--}}
                                    {{--<i class="fa fa-times"></i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>AskLunch</b>Web</a>
        </div><!-- /.login-logo -->
        <p class="category text-center mensagemErro">
            @foreach($errors->all() as $error)
                {{$error}}<br>
            @endforeach
            @if(Session::get('fail'))
                {{Session::get('fail')}}
            @endif
        </p>
        <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email" required="" autofocus="" />
        <button class="btn btn-lg btn-primary btn-block botaoEntrar" type="submit">Confirmar</button>
    </form>
</div>
@include('adminlte::layouts.partials.scripts_auth')
@endsection
