<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Usuario extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email', 'senha', 'tipo', 'cod_cliente'];
    protected $hidden = ['senha'];
    public $timestamps = false;
    protected $primaryKey = 'codigo';
    protected $table = "Usuario";

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
    public function funcionario(){
        return $this->belongsTo('App\Funcionario', 'cod_cliente');
    }

}
