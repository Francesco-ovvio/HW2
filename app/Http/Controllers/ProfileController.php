<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OldBuy;
use Session;
use DB;

class ProfileController extends BaseController{
    public function showProfile(){
        //script nell'head dove conterrò la var session privilegi
        //GET profilo
        $user = User::find(session('user_id'));
        if($user != null){
            return view('profile')->with('username', $user->username)->with('csrf_token', csrf_token())->with('privileges', session('privileges'));
        }else{
            return redirect('login');
        }
    }

    public function checkPayout(){
        //POST pagamento
        $idOrd = request('orderID');
        DB::select("call pagaOrdine('$idOrd')");
        return redirect('profile/success');
    }

    public function jobDone(){
        //GET operazione effettuata
        $user = User::find(session('user_id'));
        if($user != null){
            return view('actionSuccess')->with('username', $user->username);
        }else{
            return redirect('profile');
        }
    }

    public function getOrder(){
        //GET torna ordini di un cliente/tutti i clienti
        $privileges = session('privileges');
        if($privileges == 0){
            $shopList = OldBuy::select('IDordine', 'nomeProdotto', 'quantitaRichiesta', 'dataOrdine', 'costoTot', 'pagato')->where('IDcliente', session('cliente_id'))->orderBy('IDordine','DESC')->get();
        }else{
            $shopList = OldBuy::select('IDordine', 'IDcliente', 'nomeProdotto', 'quantitaRichiesta', 'dataOrdine', 'costoTot', 'pagato')->orderBy('IDordine', 'DESC')->get();
        }
        return $shopList;
    }
}