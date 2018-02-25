<?php

namespace App\Http\Controllers;

use App\Funcionario;
use App\Http\Requests\FuncionarioRequest;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente = Funcionario::join('Usuario', 'Cliente.codigo', 'Usuario.cod_cliente')
        ->where('Usuario.inativo', '=', '0')
        ->where('Usuario.tipo', '=', 'Cliente')
        ->get(['Usuario.codigo AS codigo_usuario',
            'Usuario.email AS email',
            'Usuario.senha AS senha',
            'Usuario.tipo AS tipo',
            'Usuario.cod_cliente AS cod_cliente',
            'Usuario.inativo AS usuario_inativo',
            'Cliente.*']);
        return view('cliente.index', compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = Funcionario::all();
        return view('cliente.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncionarioRequest $request)
    {
        $cliente = new Funcionario();
        $cliente->nome = $request->input('nome');
        $cliente->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $cliente->data_nascimento = $newDateString;
        $cliente->logradouro = $request->input('logradouro');
        $cliente->bairro = $request->input('bairro');
        if($request->numero === null){
            $cliente->numero = 0;
        }else{
            $cliente->numero = (int)$request->numero;
        }
        if($request->quadra === null){
            $cliente->quadra = 0;
        }else{
            $cliente->quadra = (int)$request->quadra;
        }
        if($request->lote === null){
            $cliente->lote = 0;
        }else{
            $cliente->lote = (int)$request->lote;
        }
        $var = true;
        $text = '';
        if((int)$request->numero === 0 &&
            (int)$request->quadra === 0 &&
            (int)$request->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($cliente->numero === 0 &&
            $cliente->quadra === 0 &&
            $cliente->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($cliente->quadra !== 0 && $cliente->lote === 0){
            $var = false;
            $text = "Favor informar o lote!";
        }
        if($cliente->quadra === 0 && $cliente->lote !== 0){
            $var = false;
            $text = "Favor informar a quadra!";
        }
        if($var) {
            $caracteres = array('(', ')', ' ');
            $varCoordenadas = str_replace($caracteres, '', $request->input('ihcoordenadas'));
            $cliente->coordenadas = $varCoordenadas;

            $cliente->save();

            if ($request->input('email') != null) {
                $count = Usuario::where('email', $request->input('email'))->count();
                if ($count < 1) {

                    $usuario = new Usuario();
                    $usuario->email = $request->input('email');
                    //$usuario->senha = bcrypt($request->input('senha'));
                    $usuario->senha = $request->input('senha');
                    $usuario->tipo = "Cliente";

                    $usuario->funcionario()->associate($cliente);

                    $usuario->save();

                    Session::flash('mensagem', 'Cliente cadastrado com sucesso!');
                } else {
                    Session::flash('mensagemErro', 'Email já cadastrado!');
                }
            }
        }else{
            Session::flash('mensagemErro', $text);
        }

        return redirect('/cliente/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Funcionario::findOrFail($id);
        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Funcionario::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuncionarioRequest $request, $id)
    {
        $cliente = Funcionario::find($id);
        $cliente->nome = $request->input('nome');
        $cliente->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $cliente->data_nascimento = $newDateString;
        $cliente->logradouro = $request->input('logradouro');
        $cliente->bairro = $request->input('bairro');
        if($request->numero === null){
            $cliente->numero = 0;
        }else{
            $cliente->numero = (int)$request->numero;
        }
        if($request->quadra === null){
            $cliente->quadra = 0;
        }else{
            $cliente->quadra = (int)$request->quadra;
        }
        if($request->lote === null){
            $cliente->lote = 0;
        }else{
            $cliente->lote = (int)$request->lote;
        }
        $var = true;
        $text = '';
        if((int)$request->numero === 0 &&
            (int)$request->quadra === 0 &&
            (int)$request->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($cliente->numero === 0 &&
            $cliente->quadra === 0 &&
            $cliente->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($cliente->quadra !== 0 && $cliente->lote === 0){
            $var = false;
            $text = "Favor informar o lote!";
        }
        if($cliente->quadra === 0 && $cliente->lote !== 0){
            $var = false;
            $text = "Favor informar a quadra!";
        }
        if($var) {
            $caracteres = array('(', ')', ' ');
            $varCoordenadas = str_replace($caracteres, '', $request->input('ihcoordenadas'));
            $cliente->coordenadas = $varCoordenadas;

            $cliente->save();

            if ($request->input('email') != null) {
                $count = Usuario::where('email', $request->input('email'))
                    ->where('cod_cliente', '<>', $id)->count();
                if ($count < 1) {

                    $usuario = Usuario::where('cod_cliente', $id)->first();
                    $usuario->email = $request->input('email');
                    $usuario->senha = $request->input('senha');
//                $usuario->senha = bcrypt($request->input('senha'));
                    $usuario->tipo = "Cliente";

                    $usuario->funcionario()->associate($cliente);

                    $usuario->update();

                    Session::flash('mensagem', 'Cliente atualizado com sucesso!');
                } else {
                    Session::flash('mensagemErro', 'Email já cadastrado!');
                }
            }
        }else{
            Session::flash('mensagemErro', $text);
        }

        return redirect('/cliente/'.$id.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente =  Funcionario::findOrFail($id);
        $var = DB::select(DB::raw("SELECT * FROM Pedido INNER JOIN Cliente ON (Pedido.cod_cliente = Cliente.codigo)
WHERE Cliente.codigo = ".$cliente->codigo." AND (Pedido.status <> 'Finalizado' AND Pedido.status <> 'Cancelado' AND Pedido.status <> 'Extraviado' AND Pedido.status <> 'Extraviado Recriado')"));
        if( empty($var)){
//            Session::flash('mensagemErro', 'pode');
            $cliente->inativo = 1;
            $cliente->update();
            Usuario::where('cod_cliente', $id)->update(['inativo' => 1]);
        }else{
            Session::flash('mensagemErro', 'Este cliente não pode ser excluído, pois possui pedidos não finalizados vinculados a ele!');
        }
//        dd($var);

        return redirect('/cliente');
    }
}
