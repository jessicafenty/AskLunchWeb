<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BebidaVenda extends Model
{
    protected $fillable = ['cod_bebida', 'valor_unitario', 'qtd', 'cod_pedido'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Bebida_Venda";
}
