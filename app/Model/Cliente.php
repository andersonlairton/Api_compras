<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = true;
    protected $fillable = ['cpf/cnpj','nome','data_cadastro']; 
}
