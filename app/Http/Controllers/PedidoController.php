<?php

namespace App\Http\Controllers;


use App\FormaPagamento;
use App\Funcionario;
use App\Pedido;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
        $pedido = Pedido::where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->where('inativo', '=', '0')->get();
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
        $pedido = Pedido::all();
        $formapagamento = FormaPagamento::all();
        $cliente = Funcionario::all();
        return view('pedido.create', compact('pedido', 'formapagamento', 'cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedido = new Pedido();
        if($request->input('codigo') !=null){
            if($request->input('codigo') == 0) {
                $pedido->entrega = 0;
                $pedido->horario = $request->input('horas') .":". $request->input('minutos').":00";
//                echo $pedido->logradouro;
            }else{
                $pedido->entrega = 1;
                $pedido->horario = "00:00:00";
            }
            date_default_timezone_set('America/Sao_Paulo');
            $data = date("Y-m-d H:i:s");
            $pedido->data_pedido = $data;
            $pedido->troco = $request->troco;
            $pedido->cod_forma_pagamento = $request->input('pagamento');
            $pedido->cod_cliente = $request->input('cliente');
            $pedido->logradouro = $request->logradouro;
            $pedido->bairro = $request->bairro;
            $pedido->numero = $request->numero;
            $pedido->quadra = $request->quadra;
            $pedido->lote = $request->lote;
            $pedido->coordenadas = $request->input('coordenadas');
            $pedido->status = "Recebido";
            $pedido->entregador = "Padrão";
            $pedido->save();
            Session::flash('mensagem', 'Pedido cadastrado com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Favor escolher uma OPÇÃO!');
        }
        return redirect('/pedido/create');
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
        $pedido = Pedido::findOrFail($id);
        $formapagamento = FormaPagamento::all();
        $cliente = Funcionario::all();
        $horario = explode(":", $pedido->horario);
        $horas = (int) $horario[0];
        $minutos = (int) $horario[1];
        return view('pedido.edit', compact('pedido','formapagamento', 'cliente', 'horas', 'minutos'));
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
        $pedido = Pedido::findOrFail($id);
        if($request->input('codigo') !=null){
            if($request->input('codigo') == 0) {
                $pedido->entrega = 0;
                $pedido->horario = $request->input('horas') .":". $request->input('minutos').":00";
//                echo $pedido->logradouro;
            }else{
                $pedido->entrega = 1;
                $pedido->horario = "00:00:00";
            }
            date_default_timezone_set('America/Sao_Paulo');
            $data = date("Y-m-d H:i:s");
            $pedido->data_pedido = $data;
            $pedido->troco = $request->troco;
            $pedido->cod_forma_pagamento = $request->input('pagamento');
            $pedido->cod_cliente = $request->input('cliente');
            $pedido->logradouro = $request->logradouro;
            $pedido->bairro = $request->bairro;
            $pedido->numero = $request->numero;
            $pedido->quadra = $request->quadra;
            $pedido->lote = $request->lote;
            $pedido->coordenadas = $request->input('coordenadas');
            $pedido->status = "Recebido";
            $pedido->entregador = "Padrão";
            $pedido->update();
            Session::flash('mensagem', 'Pedido atualizado com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Favor escolher uma OPÇÃO!');
        }
        return redirect('/pedido/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->inativo = 1;
        $pedido->update();
        Session::flash('mensagem', 'Pedido excluído com sucesso!');

        return redirect('/pedido');
    }
}
