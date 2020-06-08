<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendaRequest;
use App\Model\Cliente;
use App\Model\ItensVenda;
use App\Model\Produto;
use App\Model\Venda;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = Venda::all();

        return $vendas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(VendaRequest $dados)
    {
        $cliente = Cliente::find($dados->id_cliente);
        if (empty($cliente)) {
            return ['erro' => 'cliente invalido'];
        }
        $v =  Venda::create($dados->all());
        return [
            'status' => 'suesso',
            'nova venda gravada' => $v->id
        ];
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
    public function listar_produtos($id)
    {
        $venda = Venda::find($id);
        //ItensVenda::where('id_venda', $itens->id_venda)->where('id_produto', $itens->id_produto)->get();
        // var_dump($id);
        //die;
        //var_dump($produtos);

        if (empty($venda)) {
            return ['erro' => 'id invalido'];
        }
        $produtos = DB::select('SELECT descricao,quantidade_vendida,valor FROM itens_vendas,produtos WHERE id_venda=? AND produtos.id=itens_vendas.id_produto', [$id]);
        // return $produtos;
        // die;
        return [
            'venda' => $venda,
            'produtos' => $produtos
        ];
        // return ['status'=>'metodo show vendas com o id '.$id];
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
    public function update(Request $request, $id)
    {
        return ['status' => 'metodo update'];
    }
    public function alterarCliente(Request $dados, $id)
    {
        $venda = $this->show($id);

        if (empty($venda->data_venda) && !isset($venda['erro'])) {
            $cliente = Cliente::find($dados->id_cliente);
            if (!empty($cliente)) {
                try {
                    $venda->update($dados->all());
                    return ['status' => 'cliente alterado com sucesso'];
                } catch (Exception $erro) {
                    return $erro;
                }
            } else {
                return ['erro' => 'cliente invalido'];
            }
        } else if (isset($venda['erro'])) {
            return ['erro' => 'venda nao existe no banco de dados'];
        } else {
            return ['status' => 'venda finaliza,cliente nao pode ser alterado'];
        }
    }

    public function finalizarvenda($id)
    {
        $venda = Venda::find($id);

        if (empty($venda->data_venda)) {

            $itens = ItensVenda::where('id_venda', $id)->get();

            foreach ($itens->pluck('id_produto')->toArray() as $key => $value) {
                $prod = Produto::find($value);
                $qtdVendida = $itens->pluck('quantidade_vendida')->toArray();
                $qtdVendida = array_shift($qtdVendida);

                $prod->quantidade_estoque = $prod->quantidade_estoque - $qtdVendida;

                $prod->update(['quantidade_estoque' => $prod->quantidade_estoque]);
            }
            $venda->data_venda = new DateTime();
            $venda->update(['data_venda' => $venda->data_venda]);
            return ['status' => 'venda finalizada com sucesso'];
        } else {
            return ['erro' => 'venda ja finalizada'];
        }
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
