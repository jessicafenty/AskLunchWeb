<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('auth.login');
    }
//    public function register(){
//        return view('auth.register');
//    }
    public function attempt(Request $request){
        $email = $request->email;
        $senha = $request->senha;
        $usuario = Usuario::where('email', $email)
            ->first();

        if (! is_null($usuario)) {
//            if (Hash::check($senha, $usuario->senha)) {
            $decrypted = Crypt::decryptString($usuario->senha);
//            dd($decrypted);
            if($senha === $decrypted){
//                dd('teste');
                Auth::loginUsingId($usuario->codigo, false);
                return redirect('home');
            }

        }
        return redirect()->back()
            ->with('fail', 'Usuário e/ou senha inválidos!')
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

    public function enviarEmail(Request $request){
            $usuario = Usuario::join('Cliente', 'Usuario.cod_cliente', 'Cliente.codigo')->
            where('email', $request->email)->first();
            if(isset($usuario)) {
                $decrypted = Crypt::decryptString($usuario->senha);
                $data = array('nome' => $usuario->nome, 'senha' => $decrypted);
                Mail::send('auth.mensagem', $data , function ($message) use ($usuario) {
                    $message->to($usuario->email)->subject
                    ('AskLunchWeb - Recuperação de Senha');
                });
                Session::flash('mensagemOK', "Operação realizada com sucesso! Verifique seu email.");
                return redirect()->route('auth.login');
            }else{
                return redirect()->back()
                    ->with('mensagem', 'Email não cadastrado!')
                    ->withInput();
            }
    }
    public function formRecuperar(){
        return view('auth.recuperar');
    }

    public function logout(){
        Auth::logout();
        return redirect('/dashboard');
    }
}
