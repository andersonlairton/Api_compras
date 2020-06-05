<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

    public function clientes(){
        return $this->belongsTo(Cliente::class,'id');
    }
}
