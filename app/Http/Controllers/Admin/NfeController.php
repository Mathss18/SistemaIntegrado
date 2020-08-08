<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\nfe;
use App\Models\pedido;
use App\Services\NfeService;
use Illuminate\Http\Request;
use Auth;
use DB;
use stdClass;
use Session;

class NfeController extends Controller
{

    public function index(Request $request)
    {
        $request->session()->forget('nfe1');
        $request->session()->forget('nfe2');
        $request->session()->forget('nfe3');
        $request->session()->forget('datas');
        $request->session()->forget('produtosNfe');
        $request->session()->forget('cliente');
        
        return view('admin.nfe.index');
    }

    public function create()
    {
        $titulo = 'Gestão de SS';
        return view('admin.nfe.create-edit',compact('titulo'));
    }

    public function store(Request $request)
    {
        $nfeService = new NfeService([
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 2,
            "razaosocial" => "FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME",
            "siglaUF" => "SP",
            "cnpj" => "04568351000154",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000002",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ]);

        $xml = $nfeService->gerarNfe();
        $xmlAssinada = $nfeService->assinar($xml);
        $xmlEnviada = $nfeService->transmitir($xmlAssinada);
        $danfe = $nfeService->gerarDanfe();
        
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

    //=================EMITIR PASSO 1 ==================
    public function emitir1(Request $request)
    {
        $nfe = $request->session()->get('nfe1');
        return view('admin.nfe.emitirPasso1',compact('nfe'));
    }

    public function postEmitir1(Request $request)
    {
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        //dd($dataFormNfe);
        
        if(empty($request->session()->get('nfe1'))){
            $nfe = new nfe;
            $nfe->fill($dataFormNfe);
            $request->session()->put('nfe1', $nfe->getAttributes());
            
        }else{
            $nfe = new nfe;
            $request->session()->forget('nfe1');
            $nfe->fill($dataFormNfe);
            $request->session()->put('nfe1', $nfe->getAttributes());
        }

        $nfe1 = $request->session()->get('nfe1');
        
        $idCli = $nfe1['ID_cliente'];
        $cliente = DB::table('cliente as c')->select('c.logradouro','c.numero','c.cidade','c.uf','c.bairro','c.cep','c.telefone')->where('c.ID_cliente', $idCli)->get()->toArray();

        $request->session()->put('cliente', $cliente);

        return redirect('admin/nfe/emitirPasso2');
        
    }

    //=================EMITIR PASSO 2 ==================
    public function emitir2(Request $request)
    {
        $produto = $request->session()->get('nfe1');
        $of = $produto['OF'];
        $produtosNota = array();
        $produtosNota2 = array();
        $quantidades = array();

        $pedido = DB::table('pedido as p')->select('p.codigo','p.quantidade')->where('p.OF', $of)->get()->toArray();
        
        foreach ($pedido as $key => $value) {
            $produtoCli = DB::table('produto_cliente as p')->select('p.cod_fabricacao','p.descricao','p.ncm','p.preco_venda')->where('p.cod_fabricacao', $pedido[$key]->codigo)->get()->toArray();
            //dd($produtoCli);
            array_push($produtosNota,$produtoCli);
            
        }

        foreach ($pedido as $key => $value) {
            $qtde = DB::table('pedido as p')->select('p.codigo','p.quantidade')->where('p.OF', $of)->get()->toArray();
            //dd($produtoCli);
            array_push($quantidades,$qtde[$key]->quantidade);
            
        }

        
        foreach ($produtosNota as $key => $value) {
            array_push($produtosNota2,$produtosNota[$key][0]); 
            
        }
        
        $produtos = $produtosNota2;
        

        
        return view('admin.nfe.emitirPasso2',compact('produtos','quantidades'));
    }
    public function postEmitir2(Request $request)
    {
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        
        if(empty($request->session()->get('nfe2'))){
            $nfe = new nfe;
            $request->session()->forget('nfe2');
            $nfe->fill($dataFormNfe);
            $request->session()->put('nfe2', $nfe->getAttributes());
            
        }else{
            $nfe = new nfe;
            $request->session()->forget('nfe2');
            $nfe->fill($dataFormNfe);
            $request->session()->put('nfe2', $nfe->getAttributes());
        }
        $nfe2 = $request->session()->get('nfe2');
        //dd($nfe2);
        return redirect('admin/nfe/emitirPasso3');
        
    }

    //=================EMITIR PASSO 3 ==================
    public function emitir3(Request $request)
    {
        $nfe3 = $request->session()->get('nfe3');
        $nfe2 = $request->session()->get('nfe2');
        $nfe1 = $request->session()->get('nfe1');
        
        return view('admin.nfe.emitirPasso3',compact('nfe3','nfe2','nfe1'));
    }
    public function postEmitir3(Request $request)
    {
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        if(empty($request->session()->get('nfe3'))){
            $nfe = new nfe;
            $nfe->fill($dataFormNfe);
            $request->session()->put('nfe3', $nfe->getAttributes());
            
        }else{
            $nfe = new nfe;
            $request->session()->forget('nfe3');
            $nfe->fill($dataFormNfe);
            $request->session()->put('nfe3', $nfe->getAttributes());
        }

        //TESNTANDO

        $nfeService = new NfeService([
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 2,
            "razaosocial" => "FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME",
            "siglaUF" => "SP",
            "cnpj" => "04568351000154",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000002",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ]);

        $nfe1 = $request->session()->get('nfe1');
        $nfe2 = $request->session()->get('nfe2');
        $nfe3 = $request->session()->get('nfe3');
        $datas = $request->session()->get('datas');
        $produtos = $request->session()->get('produtos');
        $cliente = $request->session()->get('cliente');
        $data = $request->session()->all();

        //dd($data);
        
        $xml = $nfeService->gerarNfe($nfe1,$nfe2,$nfe3,$datas,$produtos,$cliente);
        $xmlAssinada = $nfeService->assinar($xml);
        
        $xmlEnviada = $nfeService->transmitir($xmlAssinada);
        //dd($xmlEnviada);
        $danfe = $nfeService->gerarDanfe();
        //dd($danfe);
        //return redirect('admin/nfe/postFinalizar');
        
    
    }

    public function addParcela(Request $request){
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $request->session()->put('datas', $dataFormNfe['datas']);
        
    }

    public function autocompleteCodigoProdNfe(Request $request){

        $firma = Auth::user()->firma;
        $produto_cliente = 
        pedido::select(DB::raw('concat(OF) as text, pedido.ID_cliente as ID_cliente, c.nome as nome,c.cpf_cnpj as cpf_cnpj,c.email as email,c.inscricao_estadual as IE'))->join('cliente as c','c.ID_cliente','=','pedido.ID_cliente')
                    ->where("OF","LIKE","%{$request->input('query')}%")->where("firma",$firma)->where('c.ID_Cliente',DB::raw('pedido.ID_cliente'))->groupBy('OF')
                    ->get();
        return response()->json($produto_cliente);
        }

}
