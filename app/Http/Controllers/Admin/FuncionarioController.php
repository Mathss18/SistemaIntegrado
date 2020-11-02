<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use DB;

class FuncionarioController extends Controller
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
        //
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

    public function AutoCompleteFunc(Request $request){
        $funcionario = 
        Funcionario::select(DB::raw('concat(nome) as text, ID_funcionario as ID_funcionario'))
                    ->where("nome","LIKE","%{$request->input('query')}%")->where('money','sim')
                    ->get();
        return response()->json($funcionario);
    
    }
}
