<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $fillable = ['username', 'password', 'email', 'pIvaCliente'];

    public $timestamps = false;

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente', 'pIvaCliente');
    }
}
?>