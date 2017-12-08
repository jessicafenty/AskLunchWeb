<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::group(['middleware' => 'auth'], function () {
//    //    Route::get('/link1', function ()    {
////        // Uses Auth Middleware
////    });
//
//    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
//    #adminlte_routes
//});
Route::group(['middleware' => ['web']], function (){
    //Route::group(['prefix' => 'auth'], function (){

        //Route::get('login', array('as' => 'auth.login', 'uses' => 'AuthController@login'));

        Route::post('login', array('as' => 'login.attempt', 'uses' => 'AuthController@attempt'));

        //Route::get('register', array('as' => 'auth.register', 'uses' => 'AuthController@register'));

        Route::post('register', array('as' => 'register.create', 'uses' => 'AuthController@create'));


        Route::get('logout',array('as' => 'auth.logout', 'uses' => 'AuthController@logout'));

    Route::group(['middleware' => ['auth']], function (){
        Route::resource('funcionario', 'FuncionarioController');
        Route::resource('categoria', 'CategoriaController');
        Route::resource('formapagamento', 'FormaPagamentoController');
        Route::resource('bebida', 'BebidaController');
        Route::resource('item', 'ItemController');
        Route::resource('pedido', 'PedidoController');
//        Route::get('filtrarStatus/{status}', 'AjaxController@filtrarStatus')->name('filtrar');
        Route::get('alterarStatus/{id}', 'AjaxController@alterarStatus');
        Route::get('enderecoCliente/{id}', 'AjaxController@trazerEndereco');
        Route::get('enderecoPedido/{id}', 'AjaxController@trazerEnderecoPedido');
        Route::get('relatorios', 'RelatorioController@exibirOpcoesRelatorio')->name('relatorios');
        Route::post('relatorioSelecionado', 'RelatorioController@index');
//        Route::get('alterarStatusRecebido/{id}', 'AjaxController@alterarStatusRecebido');
        Route::get('adicionarEntregador/{id}/{entregador}', 'AjaxController@adicionarEntregador')->name('adicionarEntregador');
        Route::get('itensAtivos',array('as' => 'item.itens', 'uses' => 'ItensController@itensAtivos'));
        Route::get('pedidosRecebidos',array('as' => 'pedido.recebido', 'uses' => 'AjaxController@selecionarRecebidos'));
        Route::get('pedidosProntos',array('as' => 'pedidos.prontos', 'uses' => 'AjaxController@selecionarProntos'));
        Route::get('pedidosProntos/{id}',array('as' => 'pedido.pronto', 'uses' => 'AjaxController@alterarStatusPronto'));

        Route::get('pedidosRecebidos/marmitas/{id}',array('as' => 'pedido.marmitas', 'uses' => 'AjaxController@showMarmitas'));
        Route::get('itens/{id}', 'AjaxController@showItens');

        Route::post('valorMarmitas', array('as' => 'valor.marmitas', 'uses' => 'AjaxController@alterarValor'));

        Route::get('cancelarPedido/{id}',array('as' => 'pedido.cancelar', 'uses' => 'AjaxController@alterarStatusCancelar'));
        Route::get('pedidosExtraviados',array('as' => 'pedidos.extraviados', 'uses' => 'AjaxController@selecionarExtraviados'));
        Route::get('pedidosExtraviados/{id}',array('as' => 'pedido.extraviado.recriar', 'uses' => 'AjaxController@recriarPedido'));
        Route::get('pedidosRota',array('as' => 'pedido.rota', 'uses' => 'AjaxController@selecionarAndamento'));
        Route::get('pedidosRota/{id}/finalizar',array('as' => 'pedido.finalizar', 'uses' => 'AjaxController@alterarStatusFinalizar'));
        Route::get('pedidosRota/{id}',array('as' => 'pedido.extraviado', 'uses' => 'AjaxController@alterarStatusExtraviado'));
        Route::get('pedidosFinalizados',array('as' => 'pedidos.finalizados', 'uses' => 'AjaxController@selecionarFinalizados'));
        Route::get('pedidosCancelados',array('as' => 'pedidos.cancelados', 'uses' => 'AjaxController@selecionarCancelados'));
        Route::get('pedidosFinalizados/{id}/restaurar',array('as' => 'pedido.finalizado.restaurar', 'uses' => 'AjaxController@restaurarPedidoFinalizado'));
        Route::get('pedidosCancelados/{id}/restaurar',array('as' => 'pedido.cancelado.restaurar', 'uses' => 'AjaxController@restaurarPedidoCancelado'));
    });
    Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function (){
        Route::get('/', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));
    });
});
