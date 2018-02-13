<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
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
        $item = Item::where('inativo', '=', '0')->get();
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
    public function store(ItemRequest $request)
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
    public function update(ItemRequest $request, $id)
    {

        $item = Item::findOrFail($id);
        $item->descricao = $request->input('descricao');
        if($request->input('status') == "Ativo") {
            $item->status_item = $request->input('status');
        }else{
            $item->status_item = "Inativo";
        }
        $item->update();
        Session::flash('mensagem', 'Item cadastrado com sucesso!');

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
        $item = Item::findOrFail($id);
        $item->inativo = 1;
        $item->update();
        Session::flash('mensagem', 'Item excluído com sucesso!');

        return redirect('/item');
    }
}
