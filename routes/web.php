<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Cliente;
use App\Models\TipoProdotto;
use App\Models\Inventario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Route::get('login', 'LoginController@login');
Route::post('login', 'LoginController@checkLog');
Route::get('logout', 'LoginController@logout');

Route::get('home', function(){
    $user = User::find(session('user_id'));
    if(isset($user)){
        //controllare relazioni
        return view('home')->with('username', $user->username);
    }else{
        return view('home')->with('username', '');
    }
});

Route::get('register', 'RegController@checkRegister');
Route::post('register', 'RegController@register');

Route::get('products', 'ProdController@showProd');
Route::get('products/data', 'ProdController@fetchData');
Route::post('products', 'ProdController@intoCart');
Route::get('products/nutrient', 'ProdController@searchNutrizionix');

Route::get('cart/data', 'CartController@returnCart');
Route::get('cart', 'CartController@showCart');
Route::post('cart/remCart', 'CartController@remCart');
Route::post('cart/pagaOrd', 'CartController@pagaOrd');
Route::get('cart/thankyou', 'CartController@thankyou');

Route::get('profile', 'ProfileController@showProfile');
Route::post('profile', 'ProfileController@checkPayout');
Route::get('profile/success', 'ProfileController@jobDone');
Route::get('profile/getOrder', 'ProfileController@getOrder');

Route::get('admin/regProd', 'AdminController@showRegProd');
Route::get('admin/newItem', 'AdminController@showNewProduct');
Route::post('admin/regProd', 'AdminController@regProd');
Route::post('admin/newItem', 'AdminController@newProduct');
Route::get('admin/success', 'AdminController@success');
Route::get('admin/dataJ', 'AdminController@currentJobs');
Route::get('admin/prodotti', 'AdminController@prodotti');