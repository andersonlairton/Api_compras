<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Model\Cliente;
use Exception;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return $clientes;
    }

    public function create(ClienteRequest $dados)
    {
        try {
            Cliente::create($dados->all());
            return ['status' => 'cadastro realizado com sucesso'];
        } catch (Exception $erro) {
            return ['erro ao cadastrar usuario' => $erro];
        }
    }

    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        $cli = Cliente::find($id);
        if (empty($cli)) {
            return ['status' => 'id invalido'];
        }
        return $cli;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $dados, $id)
    {
        $cli = Cliente::find($id);

        if (!empty($cli)) {
            try {
                $cli->update($dados->all());
                return ['status' => 'sucesso'];
            } catch (Exception $erro) {
                return ['erro' => $erro];
            }
        } else {
            return ['status' => 'usuario invalido'];
        }
    }

    public function destroy($id)
    {
        $cli = Cliente::find($id)->delete();
        return ['status' => 'deletado o  ' . $id];
    }
}
