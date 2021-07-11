<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TipoProdotto;
use App\Models\Inventario;
use App\Models\Dipendente;
use App\MOdels\Cliente;
use Session;

class ProdController extends BaseController{
    public function showProd(){
        //GET pagina
        $user = User::find(session('user_id'));
        if($user != null){
            return view('productpage')->with('username', $user->username)->with('csrf_token', csrf_token());
        }else{
            return redirect('login');
        }
    }

    public function fetchData(){
        //GET fetch
        $prodotti = Inventario::with('tipoprodotto')->get();
        return $prodotti;
    }

    public function intoCart(){
        //POST inserimento carrello
        if(Session::get('shopCart') == null){
            Session::put('shopCart', array());
        }
        $nomeProd = request('itemName');
        for($i = 0; $i<count(session('shopCart')); $i++){
            if(session('shopCart')[$i][5] == $nomeProd){
                $err=$i;
            }
        }
        if(!isset($err)){
            $randDip = Dipendente::inRandomOrder()->where('mansione', 'magazziniere')->first()->toArray();
            $pStored = TipoProdotto::with('inventario')->where('nomeProdotto', $nomeProd)->get()->toArray();
            $cliente = Cliente::find(session('cliente_id'));
            $arrayProd = array();
            $inv = $pStored[0]['inventario'];
            
            array_push($arrayProd, $cliente->id, $inv['settoreDeposito'], request('qty'), $randDip['CF'], $pStored[0]['costoPerUnita'], $pStored[0]['nomeProdotto']);
            Session::push('shopCart', $arrayProd);
        }else{
            $newShopCart = Session::get('shopCart');
            $newShopCart[$err][2]=$newShopCart[$err][2]+request('qty');
            Session::put('shopCart', $newShopCart);
        }
        return redirect('products');
    }

    public function searchNutrizionix(){
        $nomiTrad = TipoProdotto::select('nomeTrad')->get();
        $arrayReq = array();
        for($i=0; $i<count($nomiTrad); $i++){
            $request = Http::get('https://api.nutritionix.com/v1_1/search/'.$nomiTrad[$i]['nomeTrad'].'?results=0:1&fields=item_name,brand_name,item_id,nf_calories,nf_total_fat,nf_protein,nf_total_carbohydrate&appId='.env('API_ID').'&appKey='.env('API_KEY'))->json();
            array_push($arrayReq, $request);
        }        
        return $arrayReq;
    }
}