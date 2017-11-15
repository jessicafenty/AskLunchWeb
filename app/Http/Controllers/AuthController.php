<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    public function login(){
//        return view('auth.login');
//    }
//    public function register(){
//        return view('auth.register');
//    }
    public function attempt(Request $request){
        $email = $request->email;
        $senha = $request->senha;
        $usuario = Usuario::where('email', $email)
            ->first();

        if (! is_null($usuario)) {
            if (Hash::check($senha, $usuario->senha)) {
                Auth::loginUsingId($usuario->codigo, false);
                return redirect('dashboard');
            }
        }
        return redirect()->back()
            ->with('fail', 'Usuário ou senha inválidos')
            ->withInput();
    }

    public function create(Request $request){
//        $this->validate($request, [
//            'email' => ['required', 'max:255', 'email', 'unique:Usuario'],
//            'senha' => ['required', 'min:6', 'max:15'],
//            'tipo' => ['required', 'max:255'],
//            'cod_cliente' => ['required', 'max:255'],
//        ]);
        $usuario = new Usuario();
        $usuario->email = $request->email;
        $usuario->senha = bcrypt($request->input('senha'));
        $usuario->tipo = "Administrador";
        $usuario->cod_cliente = 1;
        $usuario->save();

        return redirect()->back();
    }

    public function logout(){
        Auth::logout();
        return redirect('/dashboard');
    }
}
