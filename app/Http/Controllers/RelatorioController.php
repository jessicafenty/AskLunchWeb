<?php

namespace App\Http\Controllers;

use App\Item;
use App\Pedido;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RelatorioController extends Controller
{
    public function index(Request $request){
        if(strcmp($request->input('relatorio'), "Cardápio do Dia")==0){
            $item = Item::all()->where('status_item', 'Ativo');
            $pdf = PDF::loadView('relatorio.cardapio', compact('item'));
            //return $pdf->download('item.pdf');
            return $pdf->stream();
        }
        if(strcmp($request->input('relatorio'), "Pedidos por Status")==0){
            if(($request->input('dataInicial')==null) || ($request->input('dataFinal')) == null){
                Session::flash('mensagem', 'Preencha os campos corretamente');
                return redirect('/relatorios');
            }else{
                $dtInicial = \DateTime::createFromFormat('Y-m-d', $request->input('dataInicial'));
                $dtIni = $dtInicial->format('Y-m-d');
                $dtFinal = \DateTime::createFromFormat('Y-m-d', $request->input('dataFinal'));
                $dtFim = $dtFinal->format('Y-m-d');


                $pedido = DB::select(DB::raw("SELECT status, COUNT(codigo) AS quantidade_pedidos FROM Pedido
WHERE DATE(Pedido.data_pedido) BETWEEN '". $dtIni."' AND '".$dtFim."'
GROUP BY  status"));

                $pdf = PDF::loadView('relatorio.pedidostatus', compact('pedido'));
                return $pdf->stream();

            }
        }
        if(strcmp($request->input('relatorio'), "Aniversariantes")==0){
            $mes = $request->input('mes');
            $cliente = DB::select(DB::raw("SELECT Cliente.nome, LEFT(Cliente.data_nascimento, 2) AS dia FROM Cliente 
WHERE SUBSTRING(Cliente.data_nascimento FROM 4 FOR 2) = ".$mes));

            $pdf = PDF::loadView('relatorio.aniversariantes', compact('cliente'), compact('mes'));
            return $pdf->stream();


        }
        if(strcmp($request->input('relatorio'), "totalMarmitasMes")==0){
            $mes = $request->input('mes');
            $marmitas = DB::select(DB::raw("SELECT COUNT(Marmita.codigo) as quantidade, SUM(Marmita.valor_vendido) as total 
FROM Pedido INNER JOIN Marmita ON (Pedido.codigo = Marmita.cod_pedido) WHERE Pedido.status = 'Finalizado' AND MONTH(Pedido.data_pedido) = ".$mes));

            $pdf = PDF::loadView('relatorio.marmitasMes', compact('marmitas'), compact('mes'));
            return $pdf->stream();


        }
        if(strcmp($request->input('relatorio'), "totalMarmitasDia")==0){
            $dataAtual = date("Y-m-d");
            $mesRelatorio = date("d-m-Y");
            $marmitas = DB::select(DB::raw("SELECT COUNT(Marmita.codigo) as quantidade, SUM(Marmita.valor_vendido) as total 
FROM Pedido INNER JOIN Marmita ON (Pedido.codigo = Marmita.cod_pedido) WHERE Pedido.status = 'Finalizado' AND DATE(Pedido.data_pedido) = '".$dataAtual."'"));

            $pdf = PDF::loadView('relatorio.marmitasDia', compact('marmitas'), compact('mesRelatorio'));
            return $pdf->stream();
        }
        if(strcmp($request->input('relatorio'), "totalMarmitasPeriodo")==0){
            if(($request->input('dataInicial')==null) || ($request->input('dataFinal')) == null){
                Session::flash('mensagem', 'Preencha os campos corretamente');
                return redirect('/relatorios');
            }else{
                $dtInicial = \DateTime::createFromFormat('Y-m-d', $request->input('dataInicial'));
                $dtIni = $dtInicial->format('Y-m-d');
                $dtFinal = \DateTime::createFromFormat('Y-m-d', $request->input('dataFinal'));
                $dtFim = $dtFinal->format('Y-m-d');

                $dti = $dtInicial->format('d-m-Y');
                $dtf = $dtFinal->format('d-m-Y');
                $stringData = $dti.' - '.$dtf;


                $marmitas = DB::select(DB::raw("SELECT COUNT(Marmita.codigo) as quantidade, SUM(Marmita.valor_vendido) as total 
FROM Pedido INNER JOIN Marmita ON (Pedido.codigo = Marmita.cod_pedido) WHERE Pedido.status = 'Finalizado' AND DATE(Pedido.data_pedido) BETWEEN '". $dtIni."' AND '".$dtFim."'"));


                $pdf = PDF::loadView('relatorio.marmitasPeriodo', compact('marmitas'), compact('stringData'));
                return $pdf->stream();

            }
        }
//        if(strcmp($request->input('relatorio'), "marmitasCliente")==0){
//            $marmitas = DB::select(DB::raw("SELECT Pedido.codigo AS Codigo_Pedido, Marmita.codigo AS Codigo_Marmita, Cliente.nome, Categoria_Marmita.tamanho, Item.descricao
//FROM Cliente INNER JOIN Pedido ON (Cliente.codigo = Pedido.cod_cliente)
//INNER JOIN Marmita ON (Pedido.codigo = Marmita.cod_pedido)
//INNER JOIN Item_Marmita ON (Marmita.codigo = Item_Marmita.cod_marmita)
//INNER JOIN Item ON (Item_Marmita.cod_item = Item.codigo)
//INNER JOIN Categoria_Marmita ON (Marmita.cod_categoria = Categoria_Marmita.codigo)
//GROUP BY Codigo_Pedido, Codigo_Marmita, Cliente.nome, Categoria_Marmita.tamanho, Item.descricao"));
//
//            $pdf = PDF::loadView('relatorio.marmitasCliente', compact('marmitas'));
//            return $pdf->stream();
//        }
    }
    public function exibirOpcoesRelatorio(){
        return view('relatorio.index');
    }
}
