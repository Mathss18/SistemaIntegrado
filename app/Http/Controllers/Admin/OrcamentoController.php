<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\orcamento;
use Illuminate\Http\Request;
use DB;

class OrcamentoController extends Controller
{

    public function index()
    {
        $orcamentos = new orcamento();
        $orcamentos = DB::table('orcamento as o')->join('cliente as c','o.ID_cliente','=','c.ID_cliente')->join('produto_cliente as pc','o.ID_produto_cliente','=','pc.ID_produto_cliente')->select('o.ID_orcamento','o.cod_orcamento','c.nome','pc.descricao', 'o.data')->groupBy('o.cod_orcamento')->orderBy('ID_orcamento', 'desc')->get();
        return view('admin.orcamento.index',compact('orcamentos'));
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
}
