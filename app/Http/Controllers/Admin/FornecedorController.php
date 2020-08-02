<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fornecedor;
use Auth;
use DB;

class FornecedorController extends Controller
{

    public function index()
    {
        $titulo = 'Gestão de Fornecedores';
        $fornecedores = new Fornecedor();
        $fornecedores = $fornecedores->all();
        return view('admin.fornecedor.index',compact('titulo','fornecedores'));
    }


    public function create()
    {
        $titulo = 'Gestão de Fornecedores';
        return view('admin.fornecedor.create-edit',compact('titulo'));
    }


    public function store(Request $request)
    {
        $fornecedores = new Fornecedor;
        $firma = Auth::user()->firma;
       
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $dataFormCli['firma'] = $firma;

        $fornecedores->create($dataFormCli);
        return redirect()->route('fornecedor.index')->with('success', 'Cadastro Realizado Com Sucesso!');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $fornecedor = new Fornecedor();
        $fornecedor = $fornecedor->find($id);

        return view('admin.fornecedor.create-edit',compact('fornecedor'));
    }

    public function update(Request $request, $id)
    {
        $fornecedor = new Fornecedor();
        $fornecedor = $fornecedor->find($id);
        $fornecedor->update($request->all());
        return redirect()->route('fornecedor.index')->with('success', 'Cadastro Atualizado Com Sucesso!');
    }

    public function destroy($id)
    {
        //
    }

    public function AutoCompleteFornecedores(Request $request){
        $fornecedor = 
         Fornecedor::select(DB::raw('concat(nome) as text, ID_fornecedor as value'))
                    ->where("nome","LIKE","%{$request->input('query')}%")
                    ->get();
        return response()->json($fornecedor);
        }
}
