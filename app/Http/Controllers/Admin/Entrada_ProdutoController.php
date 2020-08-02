<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\entrada_produto;
use Illuminate\Http\Request;

class Entrada_ProdutoController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        
        $entrada_produto = new entrada_produto();
       
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $entrada_produto->create($dataFormCli);
        return redirect('admin/estoque')->with('success', 'Entrada Realizada Com Sucesso!');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

 
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
