<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Location;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = true;
    protected $fillable = ['nome','cpf_cnpj','data_cadastro']; 
    
    public function vendas(){
        $this->hasMany(Location::class,'id_cliente');
    }
}
