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
            <li class="active">

                <a href="{{route('item.index')}}">
                    <i class="fa fa-cutlery"></i>
                    <span>Itens das Marmitas</span>
                </a>
            </li>
            <li class="active">

                <a href="{{route('bebida.index')}}">
                    <i class="fa fa-beer"></i>
                    <span>Bebidas do Restaurante</span>
                </a>
            </li>
            <li class="active">

                <a href="{{route('categoria.index')}}">
                    <i class="fa fa-archive"></i>
                    <span>Categorias de Marmitas</span>
                </a>
            </li>
            <li class="active">

                <a href="{{route('formapagamento.index')}}">
                    <i class="fa fa-credit-card"></i>
                    <span>Formas de Pagamentos</span>
                </a>
            </li>
            <li class="active">

                <a href="{{route('relatorios')}}">
                    <i class="fa fa-file-text"></i>
                    <span>Relatórios</span>
                </a>
            </li>
            <li class="{{$activePedido or 'treeview'}}">

                <a href="#">
                    <i class="fa fa-tasks"></i>
                    <span>Gerenciamento de Pedidos</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
                        <a href="{{route('pedido.index')}}">
                            <i class="fa fa-tasks"></i>
                            <span>Todos Pedidos</span>
                        </a>
                    </li>
                    <li class="active">

                        <a href="{{route('pedido.recebido')}}">
                            <i class="fa fa-tasks"></i>
                            <span>Pedidos Recebidos</span>
                        </a>
                    </li>
                    <li class="active">

                        <a href="{{route('pedidos.prontos')}}">
                            <i class="fa fa-tasks"></i>
                            <span>Pedidos Prontos</span>
                        </a>
                    </li>
                    <li class="active">

                        <a href="{{route('pedido.rota')}}">
                            <i class="fa fa-tasks"></i>
                            <span>Pedidos em Andamento</span>
                        </a>
                    </li>
                    <li class="active">

                        <a href="{{route('pedidos.finalizados')}}">
                            <i class="fa fa-tasks"></i>
                            <span>Pedidos Finalizados</span>
                        </a>
                    </li>
                    <li class="active">

                        <a href="{{route('pedidos.cancelados')}}">
                            <i class="fa fa-tasks"></i>
                            <span>Pedidos Cancelados</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
