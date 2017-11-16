<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $fillable = ['descricao', 'status'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Forma_Pagamento";
}
