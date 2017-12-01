<?php

namespace App\Http\Controllers;


use App\Funcionario;
use App\Pedido;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $pedido = Pedido::all();
        $pedido = Pedido::where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))->get();
        $entregador = DB::table('Usuario')
            ->join('Cliente', 'Usuario.cod_cliente', '=', 'Cliente.codigo')
            ->select('Cliente.nome')
            ->where('Usuario.tipo', '=', 'Entregador')
            ->get();
//        return view('pedido.index', compact('pedido'), compact('entregador'));
        return View::make('pedido.index')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido)
            ->with('entregador',$entregador);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);
        $cliente = Funcionario::findOrFail($pedido->cod_cliente);
        $usuario = Usuario::findOrFail($pedido->cod_cliente);
//        dd($usuario->email);
//        return view('pedido.show', compact('pedido'));
        return View::make('pedido.show')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido)
            ->with('cliente',$cliente)
            ->with('usuario',$usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
