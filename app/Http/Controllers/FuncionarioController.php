<?php

namespace App\Http\Controllers;

use App\Funcionario;
use App\Http\Requests\FuncionarioRequest;
use App\Usuario;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionario = Funcionario::join('Usuario', 'Cliente.codigo', 'Usuario.cod_cliente')
            ->where('Usuario.inativo', '=', '0')
            ->where('Usuario.tipo', '<>', 'Cliente')
            ->get(['Usuario.codigo AS codigo_usuario',
                'Usuario.email AS email',
                'Usuario.senha AS senha',
                'Usuario.tipo AS tipo',
                'Usuario.cod_cliente AS cod_cliente',
                'Usuario.inativo AS usuario_inativo',
                'Cliente.*']);
        return view('funcionario.index', compact('funcionario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $funcionario = Funcionario::all();
        return view('funcionario.create', compact('funcionario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncionarioRequest $request)
    {
//        if($request->input('ihcoordenadas') != null){
//            $caracteres = array('(', ')', ' ');
//            $varCoordenadas = str_replace($caracteres,'',$request->input('ihcoordenadas'));
//            dd($varCoordenadas);
//        }else{
//            dd($request);
//        }

        $funcionario = new Funcionario();
        $funcionario->nome = $request->input('nome');
        $funcionario->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $funcionario->data_nascimento = $newDateString;
        $funcionario->logradouro = $request->input('logradouro');
        $funcionario->bairro = $request->input('bairro');
        if($request->numero === null){
            $funcionario->numero = 0;
        }else{
            $funcionario->numero = (int)$request->numero;
        }
        if($request->quadra === null){
            $funcionario->quadra = 0;
        }else{
            $funcionario->quadra = (int)$request->quadra;
        }
        if($request->lote === null){
            $funcionario->lote = 0;
        }else{
            $funcionario->lote = (int)$request->lote;
        }
        $var = true;
        $text = '';
        if((int)$request->numero === 0 &&
            (int)$request->quadra === 0 &&
            (int)$request->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($funcionario->numero === 0 &&
            $funcionario->quadra === 0 &&
            $funcionario->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($funcionario->quadra !== 0 && $funcionario->lote === 0){
            $var = false;
            $text = "Favor informar o lote!";
        }
        if($funcionario->quadra === 0 && $funcionario->lote !== 0){
            $var = false;
            $text = "Favor informar a quadra!";
        }
        if($var) {
            $caracteres = array('(', ')', ' ');
            $varCoordenadas = str_replace($caracteres, '', $request->input('ihcoordenadas'));
            $funcionario->coordenadas = $varCoordenadas;

            $funcionario->save();

            if ($request->input('email') != null) {
                $count = Usuario::where('email', $request->input('email'))->count();
                if ($count < 1) {

                    $usuario = new Usuario();
                    $usuario->email = $request->input('email');
//                $usuario->senha = bcrypt($request->input('senha'));
                    $usuario->tipo = $request->input('tipo');
                    if($usuario->tipo === 'Entregador'){
                        $usuario->senha = $request->input('senha');
                    }else{
                        $encrypted = Crypt::encryptString($request->input('senha'));
                        $usuario->senha = $encrypted;
                    }

                    $usuario->funcionario()->associate($funcionario);

                    $usuario->save();

                    Session::flash('mensagem', 'Funcionário cadastrado com sucesso!');
                } else {
                    Session::flash('mensagemErro', 'Email já cadastrado!');
                }
            }
        }else{
            Session::flash('mensagemErro', $text);
        }

        return redirect('/funcionario/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionario.show', compact('funcionario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionario.edit', compact('funcionario'));
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
        $funcionario = Funcionario::find($id);
        $funcionario->nome = $request->input('nome');
        $funcionario->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $funcionario->data_nascimento = $newDateString;
        $funcionario->logradouro = $request->input('logradouro');
        $funcionario->bairro = $request->input('bairro');
        if($request->numero === null){
            $funcionario->numero = 0;
        }else{
            $funcionario->numero = (int)$request->numero;
        }
        if($request->quadra === null){
            $funcionario->quadra = 0;
        }else{
            $funcionario->quadra = (int)$request->quadra;
        }
        if($request->lote === null){
            $funcionario->lote = 0;
        }else{
            $funcionario->lote = (int)$request->lote;
        }
        $var = true;
        $text = '';
        if((int)$request->numero === 0 &&
            (int)$request->quadra === 0 &&
            (int)$request->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($funcionario->numero === 0 &&
            $funcionario->quadra === 0 &&
            $funcionario->lote === 0){
            $var = false;
            $text = "Favor informar número e/ou quadra e lote!";
        }
        if($funcionario->quadra !== 0 && $funcionario->lote === 0){
            $var = false;
            $text = "Favor informar o lote!";
        }
        if($funcionario->quadra === 0 && $funcionario->lote !== 0){
            $var = false;
            $text = "Favor informar a quadra!";
        }
        if($var) {
            $caracteres = array('(', ')', ' ');
            $varCoordenadas = str_replace($caracteres, '', $request->input('ihcoordenadas'));
            $funcionario->coordenadas = $varCoordenadas;

            $funcionario->save();

            if ($request->input('email') != null) {
                $count = Usuario::where('email', $request->input('email'))
                    ->where('cod_cliente', '<>', $id)->count();
                if ($count < 1) {

                    $usuario = Usuario::where('cod_cliente', $id)->first();
                    $usuario->email = $request->input('email');
//                $usuario->senha = bcrypt($request->input('senha'));
                    $usuario->tipo = $request->input('tipo');
                    if($usuario->tipo === 'Entregador'){
                        $usuario->senha = $request->input('senha');
                    }else{
                        $encrypted = Crypt::encryptString($request->input('senha'));
                        $usuario->senha = $encrypted;
                    }

                    $usuario->funcionario()->associate($funcionario);

                    $usuario->update();

                    Session::flash('mensagem', 'Funcionário atualizado com sucesso!');
                } else {
                    Session::flash('mensagemErro', 'Email já cadastrado!');
                }
            }
        }else{
            Session::flash('mensagemErro', $text);
        }

        return redirect('/funcionario/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $funcionario =  Funcionario::findOrFail($id);
        $var = DB::select(DB::raw("SELECT Pedido.* FROM Pedido INNER JOIN Cliente ON (Pedido.cod_cliente = Cliente.codigo)
WHERE Pedido.entregador = '".$funcionario->nome."' AND Pedido.status = 'Em Rota'"));
        if( empty($var)){
//            Session::flash('mensagemErro', 'pode');
            $funcionario->inativo = 1;
            $funcionario->update();
            Usuario::where('cod_cliente', $id)->update(['inativo' => 1]);
        }else{
            Session::flash('mensagemErro', 'Este funcionário não pode ser excluído, pois possui pedidos não finalizados vinculados a ele!');
        }

        return redirect('/funcionario');
    }
}
