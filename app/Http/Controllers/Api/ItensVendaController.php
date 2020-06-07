<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItensVendaRequest;
use App\Model\ItensVenda;
use App\Model\Produto;
use App\Model\Venda;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItensVendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adicionarproduto(ItensVendaRequest $itens)
    {
        $prod = Produto::find($itens->id_produto);
        $venda = Venda::find($itens->id_venda);
        $itensVenda = ItensVenda::where('id_venda', $itens->id_venda)->where('id_produto', $itens->id_produto)->get();

        if (empty($venda) || !empty($venda->data_venda)) {
            return ['erro' => 'não é possivel adicionar produtos a esta venda'];
        } else if ($itens->quantidade_vendida > $prod->quantidade_estoque) {
            return ['erro' => 'quantidade vendida não pode ser maior que a quantidade em estoque'];
        } else if (!empty($itensVenda->pluck('id')->toArray())) {
            $quantidade = $itensVenda->pluck('quantidade_vendida')->toArray();
            $quantidade = array_shift($quantidade);

            if ($quantidade > $itens->quantidade_vendida) {
                $total_venda = $venda->valor - ($prod->valor * ($quantidade - $itens->quantidade_vendida));
            } else {
                $total_venda = $venda->valor + (($prod->valor * $itens->quantidade_vendida) - ($prod->valor * $quantidade));
            }

            $venda->update(['valor' => $total_venda]);

            $id_item = $itensVenda->pluck('id')->toArray();
            $id_item = array_shift($id_item);
            ItensVenda::find($id_item)->update($itens->all());

            return ['status' => 'quantidade alterado com sucesso'];
        } else {
            $itens['data_venda'] = new DateTime();
            $total_venda = $venda->valor + ($prod->valor * $itens->quantidade_vendida);
            $venda->update(['valor' => $total_venda]);
            ItensVenda::create($itens->all());

            return ['status' => 'produto adicionado com sucesso'];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItensVendaRequest $dados, $id)
    {
        $itens = ItensVenda::find($id);
        $venda = Venda::find($dados->id_venda);
        var_dump($venda->id);
        die;
        $itens->update($dados->all());
        //var_dump($itens->quantidade_vendida);
        //return $dados;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
