<?php

namespace App\Http\Controllers;


use App\Bebida;
use App\BebidaVenda;
use App\Categoria;
use App\FormaPagamento;
use App\Funcionario;
use App\Item;
use App\ItemMarmita;
use App\Marmita;
use App\Pedido;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Expr\Cast\String_;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $pedido = Pedido::all();
        date_default_timezone_set('America/Sao_Paulo');
        $pedido = Pedido::where(DB::raw('DATE(data_pedido)'), '=', date("Y-m-d"))
            ->where('inativo', '=', '0')->get();
        $entregador = DB::table('Usuario')
            ->join('Cliente', 'Usuario.cod_cliente', '=', 'Cliente.codigo')
            ->select('Cliente.nome')
            ->where('Usuario.tipo', '=', 'Entregador')
            ->get();
//        return view('pedido.index', compact('pedido'), compact('entregador'));
        return View::make('pedido.index')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido)
            ->with('entregador',$entregador);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pedido = Pedido::where('inativo','=','0')->get();
        $formapagamento = FormaPagamento::where('inativo','=','0')->get();
        $cliente = Funcionario::where('inativo','=','0')->get();
        $itens = Item::where('status_item','=','Ativo')->
            where('inativo','=','0')->get();
        $bebidas = Bebida::where('inativo','=','0')->get();
        $categoriaGrande = Categoria::where('tamanho','Grande')->first();
        $categoriaPequena = Categoria::where('tamanho','Pequena')->first();
        return view('pedido.create', compact('pedido', 'formapagamento', 'cliente','itens','bebidas', 'categoriaGrande', 'categoriaPequena'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd(Input::get());
        try {
            $pedido = new Pedido();
            if ($request->input('codigo') != null) {
                if ($request->input('codigo') == 0) {
                    $pedido->entrega = 0;
                    $pedido->horario = $request->input('horas') . ":" . $request->input('minutos') . ":00";
//                echo $pedido->logradouro;
                } else {
                    $pedido->entrega = 1;
                    $pedido->horario = "00:00:00";
                }
                date_default_timezone_set('America/Sao_Paulo');
                $data = date("Y-m-d H:i:s");
                $pedido->data_pedido = $data;
                $pedido->troco = $request->troco;
                $pedido->cod_forma_pagamento = $request->input('pagamento');
                $pedido->cod_cliente = $request->input('cliente');
                $pedido->logradouro = $request->logradouro;
                $pedido->bairro = $request->bairro;
                $pedido->numero = $request->numero;
                $pedido->quadra = $request->quadra;
                $pedido->lote = $request->lote;
                $pedido->coordenadas = $request->input('coordenadas');
                $pedido->status = "Recebido";
                $pedido->entregador = "Padrão";
                $pedido->save();
//
                $fields = Input::get();
//
                $categoriaGrande = Categoria::where('tamanho', '=', 'Grande')->get();
                for ($i = 0; $i < $request->qtdGrande; $i++) {
                    $marmitaGrande = new Marmita();
                    $marmitaGrande->categoria()->associate($categoriaGrande[0]['codigo']);
                    $marmitaGrande->valor_vendido = $categoriaGrande[0]['valor'];
                    $marmitaGrande->pedido()->associate($pedido);
                    $marmitaGrande->save();


                    foreach ($fields as $name => $value) {
                        $p = (string)($i+1);

                        if (ends_with($name, 'G')) {
                            //dd($p[0]);
                            if (starts_with($name, $p[0])) {
                                $itemMarmitaGrande = new ItemMarmita();
                                $itemMarmitaGrande->cod_marmita = $marmitaGrande->codigo;
                                $itemMarmitaGrande->cod_item = $value;
                                $itemMarmitaGrande->save();
//                            echo $name.'<br>';
//                            echo $value.'<br>';

                            }
                        }
                    }
                }

                $categoriaPequena = Categoria::where('tamanho', '=', 'Pequena')->get();
                for ($j = 0; $j < $request->qtdPequena; $j++) {
                    $marmitaPequena = new Marmita();
                    $marmitaPequena->categoria()->associate($categoriaPequena[0]['codigo']);
                    $marmitaPequena->valor_vendido = $categoriaPequena[0]['valor'];
                    $marmitaPequena->pedido()->associate($pedido);
                    $marmitaPequena->save();

                    foreach ($fields as $name => $value) {
                        $p = (string)($j+1);

                        if (ends_with($name, 'P')) {
                            if (starts_with($name, $p[0])) {
                                $itemMarmitaPequena = new ItemMarmita();
                                $itemMarmitaPequena->cod_marmita = $marmitaPequena->codigo;
                                $itemMarmitaPequena->cod_item = $value;
                                $itemMarmitaPequena->save();
//                            echo $name.'<br>';
//                            echo $value.'<br>';

                            }
                        }
                    }
                }


                foreach ($fields as $name => $value) {
                    if (ends_with($name, 'B')) {
                        $arrBebidas = explode("-", $name);
                        if ($value != null) {
                            //$i=0;
                            //while($i < $value){
                            $bebida = new BebidaVenda();
                            $bebida->cod_bebida = $arrBebidas[0];
                            $valorBebida = Bebida::where('codigo', '=', $bebida->cod_bebida)->get();
                            $bebida->valor_unitario = $valorBebida[0]['valor'];
                            $bebida->qtd = $value;
                            $bebida->cod_pedido = $pedido->codigo;
                            $bebida->save();
                            //echo $arrBebidas[0].'-'.$value.'<br>';
                            //$i++;
                            //}
                        }
                    }
                }
                Session::flash('mensagem', 'Pedido cadastrado com sucesso!');
            } else {
                Session::flash('mensagemErro', 'Favor escolher uma OPÇÃO!');
            }
        }catch (\Exception $exception){
            dd($exception);
        }
        return redirect('/pedido/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);
        $cliente = Funcionario::findOrFail($pedido->cod_cliente);
        $usuario = Usuario::where('cod_cliente',$pedido->cod_cliente)->first();


        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d', strtotime($pedido->data_pedido));
        $codCliente = $pedido->cod_cliente;
//        echo $date;
        $marmitas = DB::select(DB::raw("SELECT Cliente.nome, Pedido.codigo,
        Categoria_Marmita.tamanho AS tamanho, Marmita.codigo AS cod_marmita
        FROM Cliente INNER JOIN Pedido ON (Cliente.codigo = Pedido.cod_cliente)
        INNER JOIN Marmita ON (Pedido.codigo = Marmita.cod_pedido)
        INNER JOIN Categoria_Marmita ON (Marmita.cod_categoria = Categoria_Marmita.codigo)
        WHERE Pedido.codigo = ".$id." AND Cliente.codigo = ".$codCliente));
//        WHERE DATE (Pedido.data_pedido) = '".$data."' AND Cliente.codigo = ".$codCliente));



//        dd($usuario->email);
//        return view('pedido.show', compact('pedido'));
        return View::make('pedido.show')
            ->with('activePedido','active treeview')
            ->with('pedido',$pedido)
            ->with('cliente',$cliente)
            ->with('usuario',$usuario)
            ->with('marmitas',$marmitas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $pedido = Pedido::findOrFail($id);
        $formapagamento = FormaPagamento::where('inativo','=','0')->get();
        $cliente = Funcionario::where('inativo','=','0')->get();
        $horario = explode(":", $pedido->horario);
        $horas = (int) $horario[0];
        $minutos = (int) $horario[1];
        $marmitasGrandes = Marmita::where('cod_pedido','=',$pedido->codigo)->where('cod_categoria','=',1)->get();
        $marmitasPequenas = Marmita::where('cod_pedido','=',$pedido->codigo)->where('cod_categoria','=',2)->get();
        //dd(sizeof($marmitas));
        $itens = Item::where('status_item','=','Ativo')->where('inativo','=','0')->get();
        $bebidasPedido = BebidaVenda::where('cod_pedido','=',$pedido->codigo)->where('inativo','=','0')->get();
        $bebidas = Bebida::where('inativo','=','0')->get();
        return view('pedido.edit', compact('pedido','formapagamento',
            'cliente', 'horas', 'minutos', 'marmitasGrandes', 'marmitasPequenas', 'bebidas','itens','bebidasPedido'));
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
        $fields = Input::get();
        //dd($fields["1C"]);
        //dd(ends_with($fields, 'C'));
        $pedido = Pedido::findOrFail($id);
        if($request->input('codigo') !=null){
            if($request->input('codigo') == 0) {
                $pedido->entrega = 0;
                $pedido->horario = $request->input('horas') .":". $request->input('minutos').":00";
//                echo $pedido->logradouro;
            }else{
                $pedido->entrega = 1;
                $pedido->horario = "00:00:00";
            }
            date_default_timezone_set('America/Sao_Paulo');
            $data = date("Y-m-d H:i:s");
            $pedido->data_pedido = $data;
            $pedido->troco = $request->troco;
            $pedido->cod_forma_pagamento = $request->input('pagamento');
            $pedido->cod_cliente = $request->input('cliente');
            $pedido->logradouro = $request->logradouro;
            $pedido->bairro = $request->bairro;
            $pedido->numero = $request->numero;
            $pedido->quadra = $request->quadra;
            $pedido->lote = $request->lote;
            $pedido->coordenadas = $request->input('coordenadas');
            $pedido->status = "Recebido";
            $pedido->entregador = "Padrão";
            $pedido->update();

            $categoriaGrande = Categoria::where('tamanho', '=', 'Grande')->first();

            $cont = 1;
            $arrCodigos = [];
            for ($i = 0; $i < $request->qtdGrande; $i++) {
                if(isset($fields[$cont.'C'])){
                    $mg = Marmita::where('codigo','=',(int)$fields[(string)$cont.'C'])->first();
                    if(isset($mg)){
                        $marmitaGrande = Marmita::find($mg->codigo);
                        $marmitaGrande->cod_categoria = $categoriaGrande->codigo;
                        $marmitaGrande->valor_vendido = $categoriaGrande->valor;
                        $marmitaGrande->pedido()->associate($pedido);
                        $marmitaGrande->update();
                        $arrCodigos[$i] = $marmitaGrande->codigo;
                    }else{
                        if((int)$fields[(string)$cont.'C'] === 0){
                            $marmitaGrande = new Marmita();
                            $marmitaGrande->categoria()->associate($categoriaGrande->codigo);
                            $marmitaGrande->valor_vendido = $categoriaGrande->valor;
                            $marmitaGrande->pedido()->associate($pedido);
                            $marmitaGrande->save();
                            $arrCodigos[$i] = $marmitaGrande->codigo;
                        }
                    }

                }

                ItemMarmita::where('cod_marmita','=',$marmitaGrande->codigo)->delete();
                foreach ($fields as $name => $value) {
                    $p = (string)$i;

                    if (ends_with($name, 'G')) {
                        if (starts_with($name, $p[0])) {
                            $itemMarmitaGrande = new ItemMarmita();
                            $itemMarmitaGrande->cod_marmita = $marmitaGrande->codigo;
                            $itemMarmitaGrande->cod_item = $value;
                            $itemMarmitaGrande->save();
                        }
                    }
                }
                $cont++;
            }
            $marmitasGrandes = Marmita::where('cod_pedido','=',$pedido->codigo)->where('cod_categoria','=',1)->get();
//            dd($arrCodigos);
            for($j=0;$j<sizeof($marmitasGrandes);$j++) {

                if(!in_array($marmitasGrandes[$j]['codigo'], $arrCodigos)){
                    ItemMarmita::where('cod_marmita', '=', $marmitasGrandes[$j]['codigo'])->delete();
                    Marmita::where('codigo', '=', $marmitasGrandes[$j]['codigo'])->delete();
//                    echo $marmitasGrandes[$j]['codigo'].' não existe'.'<br>';
                }
            }

            //MARMITAS PEQUENAS

            $categoriaPequena = Categoria::where('tamanho', '=', 'Pequena')->first();

            $contPequena = 1;
            $arrCodigosPequena = [];
            for ($i = 0; $i < $request->qtdPequena; $i++) {
                if(isset($fields[$contPequena.'D'])){
                    $mp = Marmita::where('codigo','=',(int)$fields[(string)$contPequena.'D'])->first();
                    if(isset($mp)){
                        $marmitaPequena = Marmita::find($mp->codigo);
                        $marmitaPequena->cod_categoria = $categoriaPequena->codigo;
                        $marmitaPequena->valor_vendido = $categoriaPequena->valor;
                        $marmitaPequena->pedido()->associate($pedido);
                        $marmitaPequena->update();
                        $arrCodigosPequena[$i] = $marmitaPequena->codigo;
                    }else{
                        if((int)$fields[(string)$contPequena.'D'] === 0){
                            $marmitaPequena = new Marmita();
                            $marmitaPequena->categoria()->associate($categoriaPequena->codigo);
                            $marmitaPequena->valor_vendido = $categoriaPequena->valor;
                            $marmitaPequena->pedido()->associate($pedido);
                            $marmitaPequena->save();
                            $arrCodigosPequena[$i] = $marmitaPequena->codigo;
                        }
                    }

                }

                ItemMarmita::where('cod_marmita','=',$marmitaPequena->codigo)->delete();
                foreach ($fields as $name => $value) {
                    $p = (string)$i;

                    if (ends_with($name, 'P')) {
                        if (starts_with($name, $p[0])) {
                            $itemMarmitaPequena = new ItemMarmita();
                            $itemMarmitaPequena->cod_marmita = $marmitaPequena->codigo;
                            $itemMarmitaPequena->cod_item = $value;
                            $itemMarmitaPequena->save();
                        }
                    }
                }
                $contPequena++;
            }
            $marmitasPequenas = Marmita::where('cod_pedido','=',$pedido->codigo)->where('cod_categoria','=',2)->get();
//            dd($arrCodigos);
            for($j=0;$j<sizeof($marmitasPequenas);$j++) {

                if(!in_array($marmitasPequenas[$j]['codigo'], $arrCodigosPequena)){
                    ItemMarmita::where('cod_marmita', '=', $marmitasPequenas[$j]['codigo'])->delete();
                    Marmita::where('codigo', '=', $marmitasPequenas[$j]['codigo'])->delete();
//                    echo $marmitasGrandes[$j]['codigo'].' não existe'.'<br>';
                }
            }

            $arrCodBebidas = [];
            foreach ($fields as $name => $value) {
                if (ends_with($name, 'B')) {
                    $arrBebidas = explode("-", $name);
                    if ($value != null) {
                        $b = BebidaVenda::where('cod_pedido','=',$pedido->codigo)
                            ->where('codigo','=',$arrBebidas[0])->first();
                        if($b){
                            $bebida = BebidaVenda::find($b->codigo);
                            $bebida->cod_bebida = $arrBebidas[0];
                            $valorBebida = Bebida::where('codigo', '=', $bebida->cod_bebida)->first();
                            $bebida->valor_unitario = $valorBebida->valor;
                            $bebida->qtd = $value;
                            $bebida->cod_pedido = $pedido->codigo;
                            $bebida->update();
                            $arrCodBebidas[$i] = $bebida->codigo;
                        }else{
                            $bebida = new BebidaVenda();
                            $bebida->cod_bebida = $arrBebidas[0];
                            $valorBebida = Bebida::where('codigo', '=', $bebida->cod_bebida)->first();
                            $bebida->valor_unitario = $valorBebida->valor;
                            $bebida->qtd = $value;
                            $bebida->cod_pedido = $pedido->codigo;
                            $bebida->save();
                            $arrCodBebidas[$i] = $bebida->codigo;
                        }
                    }
                }
            }
            $drinks = BebidaVenda::where('cod_pedido','=',$pedido->codigo)->get();
            for($y=0;$y<sizeof($drinks);$y++) {

                if(!in_array($drinks[$y]['codigo'], $arrCodBebidas)){
                    BebidaVenda::where('cod_pedido','=',$pedido->codigo)
                        ->where('codigo','=',$drinks[$y]['codigo'])->delete();
                }
            }


            Session::flash('mensagem', 'Pedido atualizado com sucesso!');
        }else{
            Session::flash('mensagemErro', 'Favor escolher uma OPÇÃO!');
        }
        return redirect('/pedido/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->inativo = 1;
        $pedido->update();
        Session::flash('mensagem', 'Pedido excluído com sucesso!');

        return redirect('/pedido');
    }
}
