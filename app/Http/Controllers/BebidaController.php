<?php

namespace App\Http\Controllers;

use App\Bebida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BebidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bebida = Bebida::all();
        return view('bebida.index', compact('bebida'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bebida = Bebida::all();
        return view('bebida.create', compact('bebida'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = Bebida::where('descricao',$request->input('descricao'))->count();
        if($count < 1) {
            $bebida = new Bebida();
            $bebida->descricao = $request->input('descricao');
            $bebida->quantidade = $request->input('quantidadeNum').$request->input('quantidade');
            $bebida->valor = $request->input('valor');
            $bebida->tipo = $request->input('tipo');
            $bebida->save();
            Session::flash('mensagem', 'Bebida cadastrada com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar bebidas repetidas!');
        }

        return redirect('/categoria/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bebida = Bebida::findOrFail($id);
        return view('bebida.show', compact('bebida'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bebida = Bebida::findOrFail($id);
        return view('bebida.edit', compact('bebida'));
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
        $count = Bebida::where('codigo',$id)
            ->where('descricao',$request->input('descricao'))->count();
        if($count == 1) {
            $bebida = Bebida::findOrFail($id);
            $bebida->descricao = $request->input('descricao');
            $bebida->quantidade = $request->input('quantidadeNum').$request->input('quantidade');
            $bebida->valor = $request->input('valor');
            $bebida->tipo = $request->input('tipo');
            $bebida->save();
            Session::flash('mensagem', 'Bebida cadastrada com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar bebidas repetidas!');
        }

        return redirect('/bebida/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = DB::table('Bebida_Venda')->where('cod_bebida', $id)->count();

        if($query == 0){
            $bebida = Bebida::findOrFail($id);
            $bebida->delete();
            Session::flash('mensagem', 'Bebida excluída com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não foi possível excluir a bebida selecionada pois esta possui vendas vinculadas a ela!');
        }
        return redirect('/bebida');
    }
}
