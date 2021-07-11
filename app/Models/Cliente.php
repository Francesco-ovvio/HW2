<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{
    protected $fillable = ['id', 'nome', 'cognome', 'indirizzo'];
    public $incrementing = false;

    public $timestamps = false;

    public function user(){
        return $this->hasOne('App\Models\User', 'pIvaCliente');
    }
    public function ordine(){
        return $this->hasMany('App\Models\Ordine', 'IDCliente', 'id');
    }
}
?>