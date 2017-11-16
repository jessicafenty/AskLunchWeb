<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoria = Categoria::all();
        return view('categoria.index', compact('categoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = Categoria::all();
        return view('categoria.create', compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        $count = Categoria::where('tamanho',$request->input('tamanho'))->count();
        if($count < 1) {
            $categoria = new Categoria();
            $categoria->tamanho = $request->input('tamanho');
            $categoria->valor = $request->input('valor');
            $categoria->save();
            Session::flash('mensagem', 'Categoria cadastrada com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar categorias repetidas!');
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
        $categoria = Categoria::findOrFail($id);
        return view('categoria.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, $id)
    {
        $count = Categoria::where('tamanho',$request->input('tamanho'))->count();
        if($count < 1) {
            $categoria = Categoria::findOrFail($id);
            $categoria->tamanho = $request->input('tamanho');
            $categoria->valor = $request->input('valor');
            $categoria->save();
            Session::flash('mensagem', 'Categoria cadastrada com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar categorias repetidas!');
        }

        return redirect('/categoria/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = DB::table('Marmita')->where('cod_categoria', $id)->count();

        if($query == 0){
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            Session::flash('mensagem', 'Categoria excluída com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não foi possível excluir a categoria selecionada pois esta possui marmitas vinculadas a ela!');
        }
        return redirect('/categoria');
    }
}
