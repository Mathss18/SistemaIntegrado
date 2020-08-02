<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\saida_produto;
use Illuminate\Http\Request;

class Saida_ProdutoController extends Controller
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
        
        $saida_produto = new saida_produto();
       
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        //dd($dataFormCli);
        $saida_produto->create($dataFormCli);
        return redirect('admin/estoque')->with('success', 'Saída Realizada Com Sucesso!');
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
