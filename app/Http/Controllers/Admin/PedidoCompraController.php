<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pedidoCompra;
use Illuminate\Http\Request;
use DB;
use Auth;

class PedidoCompraController extends Controller
{

    public function index()
    {
        $pedidosCompra = new pedidoCompra();
        $pedidosCompra = DB::table('pedidocompra as p')->join('fornecedor as f', 'p.ID_fornecedor', '=', 'f.ID_fornecedor')->join('produto_fornecedor as pf', 'p.ID_produto_fornecedor', '=', 'pf.ID_produto_fornecedor')
        ->select('p.ID_pedidoCompra', 'p.cod_pedidoCompra', 'f.nome', 'pf.descricao', 'p.data')->groupBy('p.cod_pedidoCompra')->orderBy('cod_pedidoCompra', 'desc')->get();
        
        //DEIXANDO A DATA NO FORMATO PT-BR (somente view)
        foreach ($pedidosCompra as $pedido) {
            $pedido->data = date('d/m/Y', strtotime($pedido->data));
        }    
        //dd($pedidosCompra);
        return view('admin.pedidoCompra.index', compact('pedidosCompra'));
    }

    public function create()
    {
        $firma = Auth::user()->firma;
        $codigoPedidoCompra = DB::table('pedidoCompra')->select('cod_pedidoCompra')
        ->where('firma',$firma)->orderBy('cod_pedidoCompra', 'desc')->first();
        
        return view('admin.pedidoCompra.create-edit', compact('firma','codigoPedidoCompra'));
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
        
        $dataFormCliPedidoCompra = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormCliOrca);
        $firma = Auth::user()->firma;
        DB::table('pedidoCompra')->insert(
            [
                'cod_pedidoCompra' => $dataFormCliPedidoCompra['cod_pedidoCompra'], 'ID_fornecedor' =>  $dataFormCliPedidoCompra['ID_fornecedor'],
                'ID_produto_fornecedor' => $dataFormCliPedidoCompra['ID_produto_fornecedor'],
                'qtde_prod' => $dataFormCliPedidoCompra['qtde_prod'], 'data' => $dataFormCliPedidoCompra['data'],
                'obs' => $dataFormCliPedidoCompra['obs'], 'prazo_entrega' => $dataFormCliPedidoCompra['prazo_entrega'],
                'cond_pagto' => $dataFormCliPedidoCompra['cond_pagto'], 'path_pedidoCompra' => 'nada',
                'firma' => $firma
            ]

        );


        return response()->json(['message' => 'Funfou'], 200);
    }

    
    public function mostrarPronto($codPedidoCompraRequest){
        $firma = Auth::user()->firma;
        $produtos = array();
        
        $ultimoPedidoCompra = DB::table('pedidoCompra')->orderBy('ID_produto_fornecedor', 'desc')->where('cod_pedidoCompra', $codPedidoCompraRequest)->where('firma', $firma)->get();
        $ultimoPedidoCompra[0]->data = date('d/m/Y', strtotime($ultimoPedidoCompra[0]->data));
        $total = 0;
        //DESCOMENTAR PARA VER DETALHES DO ORCAMENTO
        //dd($ultimoOrca);
        $IDFornecedor = $ultimoPedidoCompra[0]->ID_fornecedor;
        $fornecedor = DB::table('fornecedor')->where('ID_fornecedor', $IDFornecedor)->get();
        
        //DESCOMENTAR PARA VER CLIENTE DO ORCAMENTO
        //dd($cliente);
        foreach ($ultimoPedidoCompra as $pedido) {
            $pedido->ID_produto_fornecedor;
            $produto = DB::table('produto_fornecedor')->where('ID_produto_fornecedor', $pedido->ID_produto_fornecedor)->where('firma', $firma)->orderBy('ID_produto_fornecedor', 'desc')->get();
            array_push($produtos,$produto);
        }
        //DESCOMENTAR PARA VER PRODUTOS DO ORCAMENTO
        //dd($produtos);

        return view('admin.pedidoCompra.template', compact('ultimoPedidoCompra','produtos','fornecedor','total'));

    }
}
