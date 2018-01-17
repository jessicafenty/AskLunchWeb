<?php

namespace App\Http\Controllers;

use App\Funcionario;
use App\Usuario;
use Illuminate\Http\Request;
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
        ->get();
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
    public function store(Request $request)
    {
        $cliente = new Funcionario();
        $cliente->nome = $request->input('nome');
        $cliente->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $cliente->data_nascimento = $newDateString;
        $cliente->logradouro = $request->input('logradouro');
        $cliente->bairro = $request->input('bairro');
        $cliente->numero = $request->input('numero');
        $cliente->quadra = $request->input('quadra');
        $cliente->lote = $request->input('lote');
        $cliente->coordenadas = "0,0";

        $cliente->save();

        if($request->input('email') != null) {
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
    public function update(Request $request, $id)
    {
        $cliente = Funcionario::find($id);
        $cliente->nome = $request->input('nome');
        $cliente->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $cliente->data_nascimento = $newDateString;
        $cliente->logradouro = $request->input('logradouro');
        $cliente->bairro = $request->input('bairro');
        $cliente->numero = $request->input('numero');
        $cliente->quadra = $request->input('quadra');
        $cliente->lote = $request->input('lote');
        $cliente->coordenadas = "0,0";

        $cliente->save();

        if($request->input('email') != null) {
            $count = Usuario::where('email', $request->input('email'))
                ->where('cod_cliente', '<>', $id)->count();
            if ($count < 1) {

                $usuario = Usuario::where('cod_cliente',$id)->first();
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
        $cliente->inativo = 1;
        $cliente->update();
        Usuario::where('cod_cliente', $id)->update(['inativo' => 1]);
        return redirect('/cliente');
    }
}
