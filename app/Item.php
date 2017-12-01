<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['descricao', 'status_item'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Item";
}
