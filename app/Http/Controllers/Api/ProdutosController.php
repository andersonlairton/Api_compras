<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Model\Produto;
use Exception;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prod = Produto::all();
        return $prod;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProdutoRequest $produto)
    {
        try {
            Produto::create($produto->all());
            return ['status' => 'produto cadastrado com sucesso'];
        } catch (Exception $erro) {
            return ['erro' => $erro];
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
        $produto = Produto::find($id);
        if (empty($produto)) {
            return ['status' => 'produto invalido'];
        }
        return $produto;
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
    public function update(Request $produto, $id)
    {
        $prod = Produto::find($id);

        if (!empty($prod)) {
            try {
                $prod->update($produto->all());
                return ['status' => 'sucesso'];
            } catch (Exception $erro) {
                return ['erro' => $erro];
            }
        } else {
            return ['status' => 'produto invalido'];
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
        try {
            Produto::find($id)->delete();
            return ['status' => 'deletado o produto ' . $id];
        } catch (Exception $erro) {
            return ['status' => 'produto não pode ser apagado quando o mesmo consta em uma venda'];
        }
    }
}
