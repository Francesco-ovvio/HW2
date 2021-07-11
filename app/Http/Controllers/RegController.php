<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;
use Session;

class RegController extends BaseController{
    public function checkRegister(){
        //GET
        if(session('user_id') != null){
            return redirect('home');
        }else{
            return view('register')->with('error', '')->with('username', '')->with('csrf_token', csrf_token());
        }
    }

    public function register(){
        //POST
        $request = request();
        $error = '';
        $chkUsIva = User::where('username', $request->username)->orWhere('pIvaCliente', $request->piva)->get();
        if(count($chkUsIva) > 0){
            $error .= 'Utente o Partita iva già presente.';
        }else{
            if(strlen($request->password) < 8){
                $error .= 'La password deve avere almeno 8 caratteri.';
            }
            if(empty($request->confPass)){
                $error .= 'Non hai inserito la password di conferma.';
            }
            if($request->password != $request->confPass){
                $error .= 'Le password non coincidono.';
            }
            if(empty($request->piva) || empty($request->nome) || empty($request->cognome) || empty($request->indirizzo) || empty($request->email)){
                $error .= 'Tutti i campi cliente sono obbligatori.';
            }
            if(empty($error)){
                $cliente = Cliente::create([
                    'id' => $request->piva, //vedi qui errore cognome
                    'nome' => $request->nome,
                    'cognome' => $request->cognome,
                    'indirizzo' => $request->indirizzo
                ]);
                if($cliente){
                    $utente = User::create([
                        'username' => $request->username,
                        'password' => md5($request->password),
                        'email' => $request->email,
                        'pIvaCliente' => $request->piva
                    ]);
                    if($utente){
                        $error .= 'Account creato con successo.';
                    }else{
                        $error .= 'Impossibile creare account.';
                    }
                }else{
                    $error .= 'Impossibile creare cliente.';
                }
            }
        }
        return view('register')->with('error', $error)->with('username', '')->with('csrf_token', csrf_token());
    }
}