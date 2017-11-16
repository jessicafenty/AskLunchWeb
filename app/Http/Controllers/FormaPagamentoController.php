<?php

namespace App\Http\Controllers;

use App\FormaPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FormaPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formapagamento = FormaPagamento::all();
        return view('formapagamento.index', compact('formapagamento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formapagamento = FormaPagamento::all();
        return view('formapagamento.create', compact('formapagamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = FormaPagamento::where('descricao',$request->input('descricao'))->count();
        if($count < 1) {
            $formapagamento = new FormaPagamento();
            $formapagamento->descricao = $request->input('descricao');
            if($request->input('status') == "Ativo") {
                $formapagamento->status = $request->input('status');
            }else{
                $formapagamento->status = "Inativo";
            }
            $formapagamento->save();
            Session::flash('mensagem', 'Forma de Pagamento cadastrada com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar formas de pagamentos repetidas!');
        }

        return redirect('/formapagamento/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formapagamento = FormaPagamento::findOrFail($id);
        return view('formapagamento.show', compact('formapagamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formapagamento = FormaPagamento::findOrFail($id);
        return view('formapagamento.edit', compact('formapagamento'));
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
        $count = FormaPagamento::where('descricao',$request->input('descricao'))->count();
        if($count < 1) {
            $formapagamento = FormaPagamento::findOrFail($id);
            $formapagamento->descricao = $request->input('descricao');
            if($request->input('status') == "Ativo") {
                $formapagamento->status = $request->input('status');
            }else{
                $formapagamento->status = "Inativo";
            }
            $formapagamento->save();
            Session::flash('mensagem', 'Forma de Pagamento cadastrada com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar formas de pagamentos repetidas!');
        }

        return redirect('/formapagamento/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = DB::table('Pedido')->where('cod_forma_pagamento', $id)->count();

        if($query == 0){
            $formapagamento = FormaPagamento::findOrFail($id);
            $formapagamento->delete();
            Session::flash('mensagem', 'Forma de Pagamento excluída com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não foi possível excluir a forma de pagamento selecionada pois esta possui pedidos vinculadas a ela!');
        }
        return redirect('/formapagamento');
    }
}
