<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dipendente;
use App\Models\TipoProdotto;
use Session;
use DB;

class AdminController extends BaseController{
    public function showRegProd(){
        //GET registra Produzione
        $user = User::find(session('user_id'));
        if($user != null && session('privileges')==1){
            return view('cambioProd')->with('username', $user->username)->with('csrf_token', csrf_token())->with('error', '');
        }else{
            return redirect('home');
        }
    }

    public function showNewProduct(){
        //GET nuovo Prodotto
        $user = User::find(session('user_id'));
        if($user != null && session('privileges')==1){
            return view('newItem')->with('username', $user->username)->with('csrf_token', csrf_token())->with('error', '');
        }else{
            return redirect('home');
        }
    }

    public function success(){
        //GET azione avvenuta con successo
        $user = User::find(session('user_id'));
        return view('actionSuccess')->with('username', $user->username);
    }

    public function regProd(){
        //POST registra Produzione
        $user = User::find(session('user_id'));
        $error = '';
        $cfDip = request('cfDip');
        $qtProd = request('qtProd');
        $idProd = request('idProd');
        DB::select("call cambioProdotto('$cfDip','$qtProd','$idProd')");
        $cambio = Dipendente::select('prodottoAttuale')->where('CF', $cfDip);
        if(!empty($cambio)){
            return redirect('admin/success');
        }else{
            $error = "Impossibile effettuare l'operazione";
            return view('cambioProd')->with('username', $user->username)->with('csrf_token', csrf_token())->with('error', $error);
        }
    }

    public function currentJobs(){
        //GET fetch
        $dataJ = Dipendente::with('tipoprodotto')->get();
        return $dataJ;
    }

    public function prodotti(){
        //GET fetch
        $dataP = TipoProdotto::with('inventario')->get();
        return $dataP;
    }

    public function newProduct(){
        //POST nuovo Prodotto
        $user = User::find(session('user_id'));
        $error = '';
        $nomeProdotto = request('nomeProd');
        $tipologia = request('tipologia');
        $costoperunita = request('costoPerUnita');
        $descrizione = request('descrizione');
        $link = request('image');
        $nomeTradotto = request('nomeTrad');
        DB::select("CALL nuovoProdotto('$nomeProdotto','$tipologia','$costoperunita','$descrizione','$link','$nomeTradotto')");
        $insert = TipoProdotto::select('nomeProdotto', $nomeProdotto);
        if(!empty($insert)){
            return redirect('admin/success');
        }else{
            $error = "Impossibile effettuare l'operazione";
            return view('newItem')->with('username', $user->username)->with('csrf_token', csrf_token())->with('error', $error);
        }
    }
}