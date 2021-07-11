<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model{
    public function tipoprodotto(){
        return $this->belongsTo('App\Models\TipoProdotto', 'tipoProd', 'IDprodotto');
    }
    public function ordine(){
        return $this->hasMany('App\Models\Inventario', 'nDeposito', 'settoreDeposito');
    }
}
?>