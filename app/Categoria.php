<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['tamanho', 'valor'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Categoria_Marmita";

    public function marmita(){
        return $this->hasMany('App\Marmita', 'cod_categoria');
    }
}
