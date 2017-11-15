<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>--}}
              {{--<span class="input-group-btn">--}}
                {{--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header" style="text-align: center">Menu</li>

            <li class="active">

                <a href="{{route('funcionario.index')}}">
                    <i class="fa fa-user-plus"></i>
                    <span>Funcionários do Restaurante</span>
                </a>
            </li>
            {{--<li class="active">--}}

                {{--<a href="#">--}}
                    {{--<i class="fa fa-address-card"></i>--}}
                    {{--<span>Endereço do Funcionário</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="active">

                <a href="#">
                    <i class="fa fa-cutlery"></i>
                    <span>Itens da Marmita</span>
                </a>
            </li>
            <li class="active">

                <a href="#">
                    <i class="fa fa-beer"></i>
                    <span>Bebidas do Restaurante</span>
                </a>
            </li>
            <li class="active">

                <a href="#">
                    <i class="fa fa-archive"></i>
                    <span>Categoria de Marmita</span>
                </a>
            </li>
            <li class="active">

                <a href="#">
                    <i class="fa fa-credit-card"></i>
                    <span>Forma de Pagamento</span>
                </a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
