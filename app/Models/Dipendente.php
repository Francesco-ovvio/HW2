<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dipendente extends Model{
    public $timestamps = false;

    protected $table = 'dipendente';
    public function ordine(){
        return $this->hasMany('App\Models\Ordine', 'IDmagazz', 'CF');
    }
    public function tipoprodotto(){
        return $this->belongsTo('App\Models\TipoProdotto', 'prodottoAttuale', 'IDprodotto');
    }
}
?>