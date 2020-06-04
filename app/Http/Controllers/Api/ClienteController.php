<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return ['status'=>'metodo index'];
    }

    public function create()
    {
        return ['status'=>'metodo create'];
    }

    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        return ['status'=>'metodo show id '.$id];
    }

    public function edit($id)
    {
        return ['status'=>"metodo edit id ".$id];
    }

    public function update(Request $request, $id)
    {
        return ['staatus'=>'metodo update id '.$id];
    }

    public function destroy($id)
    {
        return['status'=>'metodo destry id '.$id];
    }
}
