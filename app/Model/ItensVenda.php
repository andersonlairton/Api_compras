<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItensVenda extends Model
{
    protected $table = 'itens_vendas';
    public $timestamps = true;
    protected $fillable = ['quantidade_vendida','id_produto','id_venda','data_venda'];
}
