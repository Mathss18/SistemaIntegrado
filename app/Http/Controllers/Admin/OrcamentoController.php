<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\orcamento;
use Illuminate\Http\Request;
use DB;
use Auth;

class OrcamentoController extends Controller
{

    public function index()
    {
        $orcamentos = new orcamento();
        $orcamentos = DB::table('orcamento as o')->join('cliente as c', 'o.ID_cliente', '=', 'c.ID_cliente')->join('produto_cliente as pc', 'o.ID_produto_cliente', '=', 'pc.ID_produto_cliente')->select('o.ID_orcamento', 'o.cod_orcamento', 'c.nome', 'pc.descricao', 'o.data')->groupBy('o.cod_orcamento')->orderBy('cod_orcamento', 'desc')->get();
        
        //DEIXANDO A DATA NO FORMATO PT-BR (somente view)
        foreach ($orcamentos as $orca) {
            $orca->data = date('d/m/Y', strtotime($orca->data));
        }    
        return view('admin.orcamento.index', compact('orcamentos'));
    }

    public function create()
    {
        $firma = Auth::user()->firma;
        $codigoOrca = DB::table('orcamento')->select('cod_orcamento')->where('firma',$firma)->orderBy('cod_orcamento', 'desc')->first();
        
        return view('admin.orcamento.create-edit', compact('firma','codigoOrca'));
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

    public function adicionar(Request $request)
    {
        $dataFormCliOrca = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormCliOrca);
        $firma = Auth::user()->firma;
        DB::table('orcamento')->insert(
            [
                'cod_orcamento' => $dataFormCliOrca['cod_orcamento'], 'ID_cliente' =>  $dataFormCliOrca['ID_cliente'],
                'ID_produto_cliente' => $dataFormCliOrca['ID_produto_cliente'],
                'qtde_prod' => $dataFormCliOrca['qtde_prod'], 'data' => $dataFormCliOrca['data'],
                'obs' => $dataFormCliOrca['obs'], 'prazo_entrega' => $dataFormCliOrca['prazo_entrega'],
                'cond_pagto' => $dataFormCliOrca['cond_pagto'], 'path_orcamento' => 'nada',
                'firma' => $firma
            ]

        );

        //$usuario = Auth::user();


        return response()->json(['message' => 'Funfou'], 200);
    }

    public function mostrar()
    {
        $firma = Auth::user()->firma;
        $produtos = array();
        $ultimoCodOrca = DB::table('orcamento')->select('cod_orcamento')->orderBy('ID_produto_cliente', 'desc')->where('firma', $firma)->first();
        $codigo = $ultimoCodOrca->cod_orcamento;
        $ultimoOrca = DB::table('orcamento')->orderBy('ID_produto_cliente', 'desc')->where('cod_orcamento', $codigo)->where('firma', $firma)->get();
        $ultimoOrca[0]->data = date('d/m/Y', strtotime($ultimoOrca[0]->data));
        $total = 0;
        //DESCOMENTAR PARA VER DETALHES DO ORCAMENTO
        //dd($ultimoOrca);
        $IDCliente = $ultimoOrca[0]->ID_cliente;
        $cliente = DB::table('cliente')->where('ID_cliente', $IDCliente)->get();
        
        //DESCOMENTAR PARA VER CLIENTE DO ORCAMENTO
        //dd($cliente);
        foreach ($ultimoOrca as $orca) {
            $orca->ID_produto_cliente;
            $produto = DB::table('produto_cliente')->where('ID_produto_cliente', $orca->ID_produto_cliente)->where('firma', $firma)->orderBy('ID_produto_cliente', 'desc')->get();
            array_push($produtos,$produto);
        }
        //DESCOMENTAR PARA VER PRODUTOS DO ORCAMENTO
        //dd($produtos);

        return view('admin.orcamento.template', compact('ultimoOrca','produtos','cliente','total'));
    }

    public function mostrarPronto($codOrcamentoRequest){
        $firma = Auth::user()->firma;
        $produtos = array();
        
        $ultimoOrca = DB::table('orcamento')->orderBy('ID_produto_cliente', 'desc')->where('cod_orcamento', $codOrcamentoRequest)->where('firma', $firma)->get();
        $ultimoOrca[0]->data = date('d/m/Y', strtotime($ultimoOrca[0]->data));
        $total = 0;
        //DESCOMENTAR PARA VER DETALHES DO ORCAMENTO
        //dd($ultimoOrca);
        $IDCliente = $ultimoOrca[0]->ID_cliente;
        $cliente = DB::table('cliente')->where('ID_cliente', $IDCliente)->get();
        
        //DESCOMENTAR PARA VER CLIENTE DO ORCAMENTO
        //dd($cliente);
        foreach ($ultimoOrca as $orca) {
            $orca->ID_produto_cliente;
            $produto = DB::table('produto_cliente')->where('ID_produto_cliente', $orca->ID_produto_cliente)->where('firma', $firma)->orderBy('ID_produto_cliente', 'desc')->get();
            array_push($produtos,$produto);
        }
        //DESCOMENTAR PARA VER PRODUTOS DO ORCAMENTO
        //dd($produtos);

        return view('admin.orcamento.template', compact('ultimoOrca','produtos','cliente','total'));

    }
}

