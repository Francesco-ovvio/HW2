<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use DB;

class CartController extends BaseController{
    public function returnCart(){
        //fetch tabella pagina cart
        if(Session::get('shopCart') == null){
            return array();
        }else{
            return Session::get('shopCart');
        }
    }

    public function showCart(){
        //Get pagina
        $user = User::find(session('user_id'));
        if($user != null){
            return view('cart')->with('username', $user->username)->with('csrf_token', csrf_token());
        }else{
            return redirect('login');
        }
    }

    public function remCart(){
        //Post rimuovi dal cart
        $entry = request('itemName');
        $shopCart = Session::get('shopCart');
        unset($shopCart[$entry]);
        $shopCartNew = array_values($shopCart);
        Session::put('shopCart', $shopCartNew);
        return redirect('cart');
    }

    public function pagaOrd(){
        //post paga ordine
        $shopCart = Session::get('shopCart');
        for($i = 0; $i<count($shopCart); $i++){
            $piva = $shopCart[$i][0];
            $settDep = $shopCart[$i][1];
            $qty = $shopCart[$i][2];
            $dip = $shopCart[$i][3];//con calma
            $done = DB::select("call nuovoOrdine('$piva', '$settDep', '$qty', '$dip')");
        }
        Session::forget('shopCart');
        return redirect('cart/thankyou');
    }

    public function thankyou(){
        $user = User::find(session('user_id'));
        if($user != null){
            return view('thankyou')->with('username', $user->username);
        }else{
            return redirect('home');
        }
    }
}