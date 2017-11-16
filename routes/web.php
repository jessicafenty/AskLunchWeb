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
    });
    Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function (){
        Route::get('/', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));
    });
});
