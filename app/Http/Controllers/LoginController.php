<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;
use Session;

class LoginController extends BaseController{
    
    public function login(){
        //GET
        if(session('user_id') != null){
            return redirect('home');
        }else{
            return view('login')->with('csrf_token', csrf_token())->with('username', '')->with('error', '');
        }
    }

    public function checkLog(){
        //POST
        $username = User::find(session('user_id'));
        if(isset($username)){
            return redirect('home');
        }else{
            $error = '';
            if(empty(request('username')) || empty(request('password'))){
                $error .= 'Inserire tutti i campi';
            }
            if(empty($error)){
                $user = User::where('username', request('username'))->where('password', md5(request('password')))->first();
                if(!isset($user)){
                    $error .= 'Username o password non valide ';
                }else{
                    $cliente = Cliente::where('id', $user->pIvaCliente)->first();
                    Session::put('user_id', $user->id);
                    Session::put('nome', $cliente->nome);
                    Session::put('cognome', $cliente->cognome);
                    Session::put('email', $user->email);
                    Session::put('indirizzo', $cliente->indirizzo);
                    Session::put('cliente_id', $cliente->id);
                    Session::put('privileges', $user->adminFlag);
                    return redirect('home');
                }
            }
            return view('login')->with('csrf_token', csrf_token())->with('username', '')->with('error', $error);
        }
    }

    public function logout(){
        //GET
        Session::flush();
        return redirect('home');
    }
}