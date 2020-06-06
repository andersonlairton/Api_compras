<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendaRequest;
use App\Model\Cliente;
use App\Model\Venda;
use Exception;
use Illuminate\Http\Request;

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
    public function show($id)
    {
        $venda = Venda::find($id);
        if (empty($venda)) {
            return ['erro' => 'id invalido'];
        }
        return $venda;
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
        
        if (empty($venda->data_venda)&&!isset($venda['erro'])) {
            $cliente = Cliente::find($dados->id_cliente);
            if (!empty($cliente)) {
                try {
                    $venda->update($dados->all());
                    return ['status'=>'cliente alterado com sucesso'];
                } catch (Exception $erro) {
                    return $erro;
                }
            } else {
                return ['erro' => 'cliente invalido'];
            }
        }else if(isset($venda['erro']))
        {
            return ['erro'=>'venda nao existe no banco de dados'];
        } 
        else {
            return ['status' => 'venda finaliza,cliente nao pode ser alterado'];
        }
    }

    public function finalizarvenda($id)
    {
        return ['status' => 'metodo finalizar venda'];
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
