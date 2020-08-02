<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{

    public function index()
    {
        $titulo = 'Gestão de Clientes e Transportadoras';
        $clientes = new Cliente();
        $clientes = $clientes->all();
        return view('admin.cliente.index',compact('titulo','clientes'));
    }


    public function create()
    {
        $titulo = 'Gestão de Clientes e Transportadoras';
        return view('admin.cliente.create-edit',compact('titulo'));
    }


    public function store(Request $request)
    {
        $cliente = new Cliente;
       
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        
        $cliente->create($dataFormCli);
        return redirect()->route('cliente.index')->with('success', 'Cadastro Realizado Com Sucesso!');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cliente = new Cliente();
        $cliente = $cliente->find($id);

        return view('admin.cliente.create-edit',compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = new Cliente();
        $cliente = $cliente->find($id);
        $cliente->update($request->all());
        return redirect()->route('cliente.index')->with('success', 'Cadastro Atualizado Com Sucesso!');
    }

    public function destroy($id)
    {
        //
    }
}
