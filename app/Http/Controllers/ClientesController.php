<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cliente;
use App\Models\Tag;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::get();
        $retorno['clientes'] = $clientes;

        return $retorno;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $retorno = ['error' => ''];

        $data = $request->only(['nome', 'email', 'descricao', 'tags']);

        $validator = Validator::make($data, [
            'nome' => 'required|string',
            'email' => 'required|email:dns|unique:clientes,email',
            'descricao' => 'required',
            'tags' => 'nullable|string',
        ]);

        if($validator->fails()) {
            $retorno['error'] = $validator->errors();
            return $retorno;
        }

        $cliente = new Cliente();
        $cliente->nome = $data['nome'];
        $cliente->email = $data['email'];
        $cliente->descricao = $data['descricao'];
        $cliente->save();

        if(isset($data['tags'])) {
            $keywords = explode(',', $data['tags']);

            foreach($keywords as $tag) {
                $tags = new Tag();
                $tags->titulo = $tag;
                $tags->cliente_id = $cliente->id;
                $tags->save();
            }
        }

        $retorno['success'] = true;
        return $retorno;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retorno = ['error' => ''];
        $cliente = Cliente::find($id);
        $tags = Tag::where(['cliente_id' => $id])->get();

        if(!$cliente) {
            $retorno['error'] = 'Cliente não encontrado';
            return $retorno;
        }

        $retorno['cliente'] = $cliente;
        $retorno['tags'] = $tags;
        $retorno['success'] = true;
        return $retorno;
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
        $retorno = ['error' => ''];

        $cliente = Cliente::find($id);
        if(!$cliente) {
            $retorno['error'] = 'Cliente inexistente';
            return $retorno;
        }

        $data = $request->only(['nome', 'email', 'descricao']);
        
        $validator = Validator::make($data, [
            'nome' => 'required|string',
            'email' => 'required|email:dns',
            'descricao' => 'required',
        ]);
        if($validator->fails()) {
            $retorno['error'] = $validator->errors();
            return $retorno;
        }

        $hasEmail = Cliente::where(['email' => $data['email']])->first();
        if($hasEmail) {
            $retorno['error'] = 'Email já existente no sistema';
            return $retorno;
        }

        if($data['email'] == $cliente['email']) {
            unset($data['email']);
        }

        foreach($data as $key => $value) {
            Cliente::where(['id' => $id])->update([$key => $value]);
        }

        $retorno['success'] = true;
        return $retorno;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $retorno = ['error' => ''];

        $cliente = Cliente::find($id);

        if(!$cliente) {
            $retorno['error'] = 'Cliente inexistente';
        } else {
            $cliente->delete();
            $retorno['success'] = true;
        }

        return $retorno;
    }
}
