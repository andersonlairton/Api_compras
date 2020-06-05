<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    public $timestamps = true;
    protected $fillable= [
        'descricao',
        'valor',
        'quantidade_estoque',
        'data_cadastro'];
}
