<?php

namespace App\Http\Controllers;

use App\Funcionario;
use App\Http\Requests\FuncionarioRequest;
use App\Usuario;
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
        $funcionario = Funcionario::where('inativo', '=', '0')->get();
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
        return view('funcionario.create', compact($funcionario));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncionarioRequest $request)
    {

        $funcionario = new Funcionario();
        $funcionario->nome = $request->input('nome');
        $funcionario->telefone = $request->input('telefone');
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $newDateString = $myDateTime->format('d/m/Y');
        $funcionario->data_nascimento = $newDateString;
        $funcionario->logradouro = $request->input('logradouro');
        $funcionario->bairro = $request->input('bairro');
        $funcionario->numero = $request->input('numero');
        $funcionario->quadra = $request->input('quadra');
        $funcionario->lote = $request->input('lote');
        $funcionario->coordenadas = "0,0";

        $funcionario->save();

        $usuario = new Usuario();
        $usuario->email = $request->input('email');
        $usuario->senha = bcrypt($request->input('senha'));
        $usuario->tipo = $request->input('tipo');

        $usuario->funcionario()->associate($funcionario);

        $usuario->save();

        Session::flash('mensagem', 'Funcionário cadastrado com sucesso!');

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
        $funcionario->numero = $request->input('numero');
        $funcionario->quadra = $request->input('quadra');
        $funcionario->lote = $request->input('lote');
        $funcionario->coordenadas = "0,0";

        $funcionario->save();

        $usuario = Usuario::find($id);
        $usuario->email = $request->input('email');
        $usuario->senha = bcrypt($request->input('senha'));
        $usuario->tipo = $request->input('tipo');

        $usuario->funcionario()->associate($funcionario);

        $usuario->update();

        Session::flash('mensagem', 'Funcionário atualizado com sucesso!');

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
        $funcionario->inativo = 1;
        $funcionario->update();
        Usuario::where('cod_cliente', $id)->update(['inativo' => 1]);
        return redirect('/funcionario');
    }
}
