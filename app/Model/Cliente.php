<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = true;
    protected $fillable = ['nome','cpf_cnpj','data_cadastro']; 
}
