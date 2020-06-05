<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';
    public $timestamps = true;
    protected $fillable = ['id_cliente', 'valor'];

    public function clientes(){
        return $this->belongsTo(Cliente::class,'id');
    }
}
