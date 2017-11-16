<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bebida extends Model
{
    protected $fillable = ['descricao','quantidade', 'valor', 'tipo'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Bebida";
}
