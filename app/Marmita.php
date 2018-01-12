<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marmita extends Model
{
    protected $fillable = ['cod_categoria', 'valor_vendido', 'cod_pedido'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Marmita";

    public function categoria(){
        return $this->belongsTo('App\Categoria', 'cod_categoria');
    }
    public function pedido(){
        return $this->belongsTo('App\Pedido', 'cod_pedido');
    }

}
