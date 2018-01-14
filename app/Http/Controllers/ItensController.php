<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemMarmita;
use Illuminate\Http\Request;

class ItensController extends Controller
{
    public function itensAtivos(){
        $item = Item::all()->where('status_item', 'Ativo');
        return view('item.itens', compact('item'));
    }
    public function itensMarmitasGrandes($codMarmita){
        $itens = ItemMarmita::join('Marmita','Item_Marmita.cod_marmita','Marmita.codigo')
            ->where('cod_categoria', '=', 1)
            ->where('cod_marmita','=',$codMarmita)->get();
        return response()->json(json_encode($itens));
    }
    public function itensMarmitasPequenas($codMarmita){
        $itens = ItemMarmita::join('Marmita','Item_Marmita.cod_marmita','Marmita.codigo')
            ->where('cod_categoria', '=', 2)
            ->where('cod_marmita','=',$codMarmita)->get();
        return response()->json(json_encode($itens));
    }
}
