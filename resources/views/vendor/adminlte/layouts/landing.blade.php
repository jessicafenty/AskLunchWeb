<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>

    <title>{{ trans('AskLunchWeb') }}</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .mySlides {
            display:none;
        }
        .myDiv{
            position:fixed;
            width: 100%;
            height: 40%;
            bottom: 500px;
        }

        div img {
            display: block;
            width: 100%;
            height:800px;
        }

    </style>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var slideIndex = 0;
            carousel();

            function carousel() {
                var i;
                var x = document.getElementsByClassName("mySlides");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                slideIndex++;
                if (slideIndex > x.length) {slideIndex = 1}
                x[slideIndex-1].style.display = "block";
                setTimeout(carousel, 2000); // Change image every 2 seconds
            }


        });
    </script>
</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50">

<div id="app" v-cloak>
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><b>AskLunchWeb</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                        {{--<li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>--}}
                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

    {{--<h2 class="w3-center">AskLunch</h2>--}}

    <div class="myDiv">
        <img class="mySlides" src="{{URL::asset('/images/delivery.jpg')}}">
        <img class="mySlides" src="{{URL::asset('/images/comida.jpg')}}">
        <img class="mySlides" src="{{URL::asset('/images/prato.jpg')}}">
    </div>






    <footer class="navbar navbar-default navbar-fixed-bottom">
        <div id="c">
            <div class="container">
                <p>
                    <strong>ASKLUNCH <br> Copyright &copy; 2017 </strong>
                </p>
            </div>
        </div>
    </footer>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{--<script src="{{ url (mix('/js/app-landing.js')) }}"></script>--}}
{{--<script>--}}
    {{--$('.carousel').carousel({--}}
        {{--interval: 3500--}}
    {{--})--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
