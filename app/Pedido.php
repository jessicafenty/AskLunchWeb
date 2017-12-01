<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['data_pedido', 'troco', 'cod_forma_pagamento', 'cod_cliente',
        'entrega', 'horario', 'logradouro', 'bairro', 'numero', 'quadra', 'lote',
        'status', 'entregador', 'coordenadas'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Pedido";

    public function funcionario(){
        return $this->belongsTo('App\Funcionario', 'cod_cliente');
    }

    public function formapagamento(){
        return $this->belongsTo('App\FormaPagamento', 'cod_forma_pagamento');
    }
}
