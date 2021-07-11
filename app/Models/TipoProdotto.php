<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TipoProdotto extends Model{
    public function inventario(){
        return $this->hasOne('App\Models\Inventario', 'tipoProd', 'IDprodotto');
    }
    public function dipendente(){
        return $this->hasMany('App\Models\Dipendente', 'prodottoAttuale', 'IDprodotto');
    }
}
?>