<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItensController extends Controller
{
    public function itensAtivos(){
        $item = Item::all()->where('status_item', 'Ativo');
        return view('item.itens', compact('item'));
    }
}
