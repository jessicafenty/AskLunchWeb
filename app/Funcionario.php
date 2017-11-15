<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = ['nome', 'telefone', 'data_nascimento', 'logradouro', 'bairro',
        'numero', 'quadra', 'lote', 'coordenadas'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Cliente";

    public function usuario(){
        return $this->hasOne('App\Usuario', 'cod_cliente');
    }
}
