<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Item::all();
        return view('item.index', compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = Item::all();
        return view('item.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = Item::where('descricao',$request->input('descricao'))->count();
        if($count < 1) {
            $item = new Item();
            $item->descricao = $request->input('descricao');
            if($request->input('status') == "Ativo") {
                $item->status_item = $request->input('status');
            }else{
                $item->status_item = "Inativo";
            }
            $item->save();
            Session::flash('mensagem', 'Item cadastrado com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar itens repetidos!');
        }

        return redirect('/item/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('item.edit', compact('item'));
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
        $count = Item::where('codigo',$id)
            ->where('descricao',$request->input('descricao'))->count();
        if($count == 1) {
            $item = Item::findOrFail($id);
            $item->descricao = $request->input('descricao');
            if($request->input('status') == "Ativo") {
                $item->status_item = $request->input('status');
            }else{
                $item->status_item = "Inativo";
            }
            $item->save();
            Session::flash('mensagem', 'Item cadastrado com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não é possível cadastrar itens repetidos!');
        }

        return redirect('/item/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = DB::table('Item_Marmita')->where('cod_item', $id)->count();

        if($query == 0){
            $item = Item::findOrFail($id);
            $item->delete();
            Session::flash('mensagem', 'Item excluído com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Não foi possível excluir o item selecionado pois este possui marmitas vinculadas a ele!');
        }
        return redirect('/item');
    }
}
