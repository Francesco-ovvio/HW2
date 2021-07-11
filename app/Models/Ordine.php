<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ordine extends Model{
    protected $table = 'ordine';
    public $timestamps = false;
    protected $primaryKey = 'IDordine';
    protected $fillable = ['nDeposito', 'IDcliente', 'IDmagazz', 'quantitaRichiesta'];

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente', 'IDCliente', 'id');
    }
    public function inventario(){
        return $this->belongsTo('App\Models\Inventario', 'nDeposito', 'settoreDeposito');
    }
    public function dipendente(){
        return $this->belongsTo('App\Models\Dipendente', 'IDmagazz', 'CF');
    }
}
?>