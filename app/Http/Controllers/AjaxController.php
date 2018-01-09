<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Item;
use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AjaxController extends Controller
{
    public function alterarStatus($id)
    {
        $item = Item::findOrFail($id);
        if($item->status_item == "Ativo") {
            $item->status_item = "Inativo";
        }else{
            $item->status_item = "Ativo";
        }
        $item->save();
    }
    public function selecionarRecebidos()
    {
        $pedido = Pedido::where('status', '=', 'Recebido')
            ->where('inativo', '=', '0')
            ->where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->get();
//        return view('pedido.recebido', compact('pedido'));
        return View::make('pedido.recebido')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido);
    }
    public function selecionarAndamento()
    {
        $pedido = Pedido::where('status', '=', 'Em Rota')
            ->where('inativo', '=', '0')
            ->where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->get();
//        return view('pedido.rota', compact('pedido'));
        return View::make('pedido.rota')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido);
    }
    public function selecionarFinalizados()
    {
        $pedido = Pedido::where('status', '=', 'Finalizado')
            ->where('inativo', '=', '0')
            ->where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->get();
//        return view('pedido.finalizado', compact('pedido'));
        return View::make('pedido.finalizado')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido);
    }
    public function selecionarCancelados()
    {
        $pedido = Pedido::where('status', '=', 'Cancelado')
            ->where('inativo', '=', '0')
            ->where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->get();
//        return view('pedido.cancelado', compact('pedido'));
        return View::make('pedido.cancelado')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido);
    }
    public function alterarStatusPronto($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Pronto';
        $pedido->update();
        return redirect('pedidosRecebidos');
    }
    public function alterarStatusCancelar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Cancelado';
        $pedido->update();
        return redirect('pedidosProntos');
    }
    public function alterarStatusFinalizar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Finalizado';
        $pedido->update();
        return redirect('pedidosRota');
    }
    public function alterarStatusExtraviado($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Extraviado';
        $pedido->update();
        return redirect('pedidosRota');
    }
    public function restaurarPedidoFinalizado($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Pronto';
        $pedido->entregador = 'Padrão';
        $pedido->update();
        return redirect('pedidosFinalizados');
    }
    public function restaurarPedidoCancelado($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Pronto';
        $pedido->entregador = 'Padrão';
        $pedido->update();
        return redirect('pedidosCancelados');
    }
    public function selecionarProntos()
    {
        $pedido = Pedido::where('status', '=', 'Pronto')
//            ->where('entrega', '=', 1)
            ->where('entregador', '=', 'Padrão')
            ->where('inativo', '=', '0')
            ->where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->get();
        $entregador = DB::table('Usuario')
            ->join('Cliente', 'Usuario.cod_cliente', '=', 'Cliente.codigo')
            ->select('Cliente.nome')
            ->where('Usuario.tipo', '=', 'Entregador')
            ->get();
//        return view('pedido.pronto', compact('pedido', 'entregador'));
        return View::make('pedido.pronto')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido)
            ->with('entregador',$entregador);
    }
    public function adicionarEntregador($id, $entregador)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'Em Rota';
        $pedido->entregador = $entregador;
        $pedido->update();
        return response()->json(json_encode('http://127.0.0.1:8000/pedidosProntos'));
    }

    public function showMarmitas($id)
    {
        $pedido = Pedido::findOrFail($id);
        $data = date('Y-m-d', strtotime($pedido->data_pedido));
        $codCliente = $pedido->cod_cliente;
//        echo $date;
        $marmitas = DB::select(DB::raw("SELECT Cliente.nome, Pedido.codigo,
Categoria_Marmita.tamanho AS tamanho, Marmita.codigo AS cod_marmita
FROM Cliente INNER JOIN Pedido ON (Cliente.codigo = Pedido.cod_cliente)
INNER JOIN Marmita ON (Pedido.codigo = Marmita.cod_pedido)
INNER JOIN Categoria_Marmita ON (Marmita.cod_categoria = Categoria_Marmita.codigo)
WHERE DATE (Pedido.data_pedido) = '".$data."' AND Cliente.codigo = ".$codCliente));
        return view('pedido.showMarmitas', compact('marmitas'));
    }
    public function showItens($id)
    {
        $itens = DB::select(DB::raw("SELECT Item.descricao 
FROM Item INNER JOIN Item_Marmita ON (Item.codigo = Item_Marmita.cod_item)
WHERE Item_Marmita.cod_marmita = ".$id." ORDER BY Item.descricao"));
        return response()->json(json_encode($itens));
    }

    public function alterarValor(Request $request)
    {
        $categoria1 = Categoria::findOrFail($request->input('codigoGrande'));
        $categoria1->valor = $request->input('novoValorGrande');
        $categoria1->update();
        $categoria2 = Categoria::findOrFail($request->input('codigoPequena'));
        $categoria2->valor = $request->input('novoValorPequena');
        $categoria2->update();
        return redirect('categoria');
    }

    public function trazerEndereco($id)
    {
        $endereco = DB::select(DB::raw("SELECT logradouro, bairro, numero, quadra, lote, coordenadas FROM Cliente WHERE inativo = 0 AND codigo = ".$id));
        return response()->json(json_encode($endereco));
    }
    public function trazerEnderecoPedido($id)
    {
        $endereco = DB::select(DB::raw("SELECT logradouro, bairro, numero, quadra, lote, coordenadas FROM Pedido WHERE cod_cliente = ".$id));
        return response()->json(json_encode($endereco));
    }
    public function recriarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $novoPedido = new Pedido();
        $novoPedido->data_pedido = date("Y-m-d");
        $novoPedido->troco = $pedido->troco;
        $novoPedido->cod_forma_pagamento = $pedido->cod_forma_pagamento;
        $novoPedido->cod_cliente = $pedido->cod_cliente;
        $novoPedido->logradouro = $pedido->logradouro;
        $novoPedido->bairro = $pedido->bairro;
        $novoPedido->numero = $pedido->numero;
        $novoPedido->quadra = $pedido->quadra;
        $novoPedido->lote = $pedido->lote;
        $novoPedido->coordenadas = $pedido->coordenadas;
        $novoPedido->status = "Recebido";
        $novoPedido->entregador = "Padrão";
        $novoPedido->entrega = $pedido->entrega;
        $novoPedido->horario = $pedido->horario;
        $novoPedido->save();
        Pedido::where('codigo', $id)->update(['status' => 'Extraviado Recriado']);
        return redirect('pedidosExtraviados');
    }
    public function selecionarExtraviados()
    {
        $pedido = Pedido::where('status', '=', 'Extraviado')
            ->where('inativo', '=', '0')
            ->where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->get();

        return View::make('pedido.extraviado')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido);
    }


}
