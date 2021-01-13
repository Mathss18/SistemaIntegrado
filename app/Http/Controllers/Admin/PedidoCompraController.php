<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pedidoCompra;
use App\Models\produto_fornecedor;
use Illuminate\Http\Request;
use DB;
use Auth;

class PedidoCompraController extends Controller
{

    public function index()
    {
        $firma = Auth::user()->firma;
        $pedidosCompra = new pedidoCompra();
        $pedidosCompra = DB::table('pedidocompra as p')->join('fornecedor as f', 'p.ID_fornecedor', '=', 'f.ID_fornecedor')->join('produto_fornecedor as pf', 'p.ID_produto_fornecedor', '=', 'pf.ID_produto_fornecedor')
            ->select('p.ID_pedidoCompra', 'p.cod_pedidoCompra', 'f.nome', 'pf.descricao', 'p.data')->where('p.firma', $firma)->groupBy('p.cod_pedidoCompra')->orderBy('cod_pedidoCompra', 'desc')->get();

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
            ->where('firma', $firma)->orderBy('cod_pedidoCompra', 'desc')->first();

        return view('admin.pedidoCompra.create-edit', compact('firma', 'codigoPedidoCompra'));
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

    public function atualizar(Request $request){
        $firma = Auth::user()->firma;
        $dataForm = $request->except([
            '_token',
        ]);

        $array = json_decode($dataForm['json'] );
        $qtdProd = sizeof($array);
        
        //SE TODOS OS PORDUTOS FOREM EXCLUIDOS, O PEDIDO DE COMPRA É EXCLUIDO
        if($qtdProd <= 1){
            var_dump((int)$array[0]->cod_pedidoCompra);
            DB::table('pedidocompra')->where('cod_pedidoCompra',(int)$array[0]->cod_pedidoCompra)->delete();
            return response()->json(['message' => 'excluido'], 500);
        }
        else{

        //Altera a quantidade de produto do pedido de compra 
        for ($i=0; $i < $qtdProd-1; $i++) { 
            $pedidoCompra = pedidoCompra::find($array[$i]->ID);
            $pedidoCompra->update(
                [
                    'qtde_prod' => $array[$i]->Qtde, 
                ]
                );
        }
        //Altera o valor de produto do produto_fornecedor
        for ($i=0; $i < $qtdProd-1; $i++) { 
            $produtoForne = produto_fornecedor::find($array[$i]->ID_Prod);
            $produtoForne->update(
                [
                    'preco_venda' => $array[$i]->Valor, 
                    'last_preco' => date('d/m/Y')
                ]
                );
        }

        for ($i=0; $i < $qtdProd; $i++) { 
            $array[$i] = (array)$array[$i];
        }
        $pedidoCompra = DB::table('pedidoCompra')->select('*')
        ->where('cod_pedidoCompra',$array[0]['cod_pedidoCompra'])
        ->where('firma',$firma)->get()->toArray();
        

        $tamPedidoCompra = sizeof($pedidoCompra);
        for ($i=0; $i < $tamPedidoCompra; $i++) { 
            $pedidoCompra[$i] = (array)$pedidoCompra[$i];
        }

        foreach($pedidoCompra as $aV){
            $arrayFull[] = $aV['ID_pedidoCompra'];
        }
        
        foreach($array as $aV){
            $arrayPedidoCompra[] = (int)$aV['ID'];
        }
        array_pop($arrayPedidoCompra);
        
        $diff = array_diff($arrayFull,$arrayPedidoCompra);

        foreach ($diff as $IDpedidoCOmpra) {
            DB::table('pedidocompra')->where('ID_pedidoCompra',$IDpedidoCOmpra)->delete();

        }
        
        
        return response()->json(['message' => 'Funfou'], 200);
    }
        
    }

    
    
    public function aprovar(Request $request)
    {
        $dataForm = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $qtdDatas = count($dataForm['datas']);
        $firma = Auth::user()->firma;

        $fornecedor = DB::table('fornecedor')->select('*')->where('ID_fornecedor', $dataForm['ID_Fornecedor'])->first();
        $pedidoCompra = DB::table('pedidocompra')->select('*')->where('cod_pedidoCompra', $dataForm['codPedidoCompra'])->where('firma',$firma)->get();

        if ($pedidoCompra[0]->firma == 'FM') {
            $banco = 2;
        } else {
            $banco = 5;
        }
        
        
        for ($i = 0; $i < $qtdDatas; $i++){

            DB::table('evento')->insert(
            [
                'title' =>'- Aberto', 
                'start' => $dataForm['datas'][$i],
                'color' => '#f1948c', 
                'valor' =>$dataForm['valores'][$i],
                'ID_fornecedor' =>$fornecedor->ID_fornecedor,
                'favorecido' => $fornecedor->nome,
                'tipoFav' => 'fornecedor',
                'situacao' => 'on',
                'ID_banco' => $banco,
                'firma' => $pedidoCompra[0]->firma,
                'description' => 'Pedido de compra: '.$pedidoCompra[0]->cod_pedidoCompra.' - '.($i+1)."\n".'Nfe: '.$dataForm['numeroNfe']
            ]
            );
            
        }
        
        foreach ($pedidoCompra as $pc) {
            $pc->status = 'Aprovado';
            DB::table('pedidocompra')->where('ID_pedidoCompra', $pc->ID_pedidoCompra)
                ->update([
                    'status' => 'Aprovado',
                ]);
        }
        
        foreach ($pedidoCompra as $pc) {
            $i = 0;
            $produto = DB::table('produto_fornecedor')->select('*')->where('ID_produto_fornecedor', $pc->ID_produto_fornecedor)->get();
            DB::table('entrada_produto')->insert(
                [
                    'ID_produto' => $pc->ID_produto_fornecedor, 
                    'qtde' => $pc->qtde_prod,
                    'valor_unitario' => $produto[$i]->preco_venda, 
                ]
                );
                $i++;
        }
        //dd($pedidoCompra);
        return redirect()->back();
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
        $lastId = DB::table('pedidoCompra')->insertGetId(
            [
                'cod_pedidoCompra' => $dataFormCliPedidoCompra['cod_pedidoCompra'], 'ID_fornecedor' =>  $dataFormCliPedidoCompra['ID_fornecedor'],
                'ID_produto_fornecedor' => $dataFormCliPedidoCompra['ID_produto_fornecedor'],
                'qtde_prod' => $dataFormCliPedidoCompra['qtde_prod'], 'data' => $dataFormCliPedidoCompra['data'],
                'obs' => $dataFormCliPedidoCompra['obs'], 'prazo_entrega' => $dataFormCliPedidoCompra['prazo_entrega'],
                'cond_pagto' => $dataFormCliPedidoCompra['cond_pagto'], 'path_pedidoCompra' => 'nada',
                'firma' => $firma
            ]

        );

        
        return response()->json(['message' => 'Funfou','lastId' => $lastId], 200);
    }


    public function mostrarPronto($codPedidoCompraRequest)
    {
        //dd($codPedidoCompraRequest);
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
            array_push($produtos, $produto);
        }
        //DESCOMENTAR PARA VER PRODUTOS DO ORCAMENTO
        //dd($produtos);

        return view('admin.pedidoCompra.template', compact('ultimoPedidoCompra', 'produtos', 'fornecedor', 'total','firma'));
    }
}
