<?php

namespace App\Http\Controllers;

use App\FormaPagamento;
use App\Http\Requests\FormaPagamentoRequest;
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
        $formapagamento = FormaPagamento::where('inativo', '=', '0')->get();
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
    public function store(FormaPagamentoRequest $request)
    {
        if($request->input('formapagamento') != null) {
            $count = FormaPagamento::where(DB::raw('LOWER(descricao)'), strtolower($request->input('formapagamento')))->
                where('inativo', '0')->count();
            if ($count < 1) {
                $formapagamento = new FormaPagamento();
                $formapagamento->descricao = $request->formapagamento;
                if ($request->input('status') == "Ativo") {
                    $formapagamento->status = $request->input('status');
                } else {
                    $formapagamento->status = "Inativo";
                }
                $formapagamento->save();
                Session::flash('mensagem', 'Forma de Pagamento atualizada com sucesso!');
            } else {
                Session::flash('mensagemErro', 'Não é possível cadastrar formas de pagamentos repetidas!');
            }
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
    public function update(FormaPagamentoRequest $request, $id)
    {
        if($request->input('formapagamento') != null) {
            $count = FormaPagamento::where(DB::raw('LOWER(descricao)'), strtolower($request->input('formapagamento')))->
            where('inativo', '0')->
            where('codigo', '<>', $id)->count();
            if ($count < 1) {
                $formapagamento = FormaPagamento::findOrFail($id);
                $formapagamento->descricao = $request->formapagamento;
                if ($request->input('status') == "Ativo") {
                    $formapagamento->status = $request->input('status');
                } else {
                    $formapagamento->status = "Inativo";
                }
                $formapagamento->update();
                Session::flash('mensagem', 'Forma de Pagamento atualizada com sucesso!');
            } else {
                Session::flash('mensagemErro', 'Não é possível cadastrar formas de pagamentos repetidas!');
            }
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

        $formapagamento = FormaPagamento::findOrFail($id);
        $formapagamento->inativo = 1;
        $formapagamento->update();
        Session::flash('mensagem', 'Forma de Pagamento excluída com sucesso!');

        return redirect('/formapagamento');
    }
}
