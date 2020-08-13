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
        $request->session()->forget('transp');
        $request->session()->forget('cliente');

        $firma = Auth::user()->firma;
        $nfe = DB::table('nfe as n')->join('cliente as c','n.ID_cliente','=','c.ID_cliente')->select('n.ID_nfe','n.OF','n.nNF', 'n.chaveNF', 'c.nome','n.data_abertura')->orderBy('ID_nfe', 'desc')->get();
        return view('admin.nfe.index',compact('nfe'));
    }

    public function create()
    {
        $titulo = 'Gestão de NFe';
        return view('admin.nfe.create-edit',compact('titulo'));
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

    public function finalizarNfe(Request $request){
        $nfe = $request->session()->all();
        return view('admin.nfe.finalizarNfe',compact('nfe'));
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
        
        //Armazendnado os dados do cliente na session cliente
        $idCli = $nfe1['ID_cliente'];
        $cliente = DB::table('cliente as c')->select('c.logradouro','c.numero','c.cidade','c.uf','c.bairro','c.cep','c.telefone','c.ibge')->where('c.ID_cliente', $idCli)->get()->toArray();
        $request->session()->put('cliente', $cliente);
        
        //Armazendnado os dados da transp na session transp
        $idTrasnp = $nfe1['ID_transp'];
        $transp = DB::table('cliente as c')->select('c.logradouro','c.numero','c.cidade','c.uf','c.bairro','c.cep','c.telefone','c.ibge','c.inscricao_estadual')->where('c.ID_cliente', $idTrasnp)->get()->toArray();
        $request->session()->put('transp', $transp);

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
        
        // =========== TRAZENDO TODAS AS INFOS DE PRODUTOS ===============
        foreach ($pedido as $key => $value) {
            $produtoCli = DB::table('produto_cliente as p')->select('p.cod_fabricacao','p.descricao','p.ncm','p.preco_venda')->where('p.cod_fabricacao', $pedido[$key]->codigo)->get()->toArray();
            array_push($produtosNota,$produtoCli);   
        }
        foreach ($pedido as $key => $value) {
            $qtde = DB::table('pedido as p')->select('p.codigo','p.quantidade')->where('p.OF', $of)->get()->toArray();
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


        // ============== GERANDO A NOTA \o/ =====================

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
        $transp = $request->session()->get('transp');
        $cliente = $request->session()->get('cliente');
        $data = $request->session()->all();
        $ultimo = DB::table('nfe')->orderBy('ID_nfe', 'desc')->first();
        //dd($ultimo);
        $nNFdb = $ultimo->nNF+1;
        
        //DESCOMENTAR ESSA LINHA PARA VER O ARMAZENAMENTO DA SESSION
        //dd($data);
        
        $xml = $nfeService->gerarNfe($nfe1,$nfe2,$nfe3,$datas,$transp,$cliente,$nNFdb,$request);
        //dd($xml); $xml[0] -Nfe  /  $xml[1] -chaveNfe  /  $xml[2] -nNF
        $xmlAssinada = $nfeService->assinar($xml[0]);

        //DESCOMENTAR ESSA LINHA PARA VER A VALIDACAO DO XML NO SEFAZ
        //dd($xmlAssinada);

        $xmlEnviada = $nfeService->transmitir($xmlAssinada,$xml[1]);
        //DESCOMENTAR ESSA LINHA PARA VER O SE ESTÁ FUNFANDO A XML
        //dd($xmlEnviada);

        if($xmlEnviada==null){
            //CASO A NOTA SEJA REJEITADA 
            return redirect('admin/nfe')->with('error', 'Nada foi feito, NFe com problema, favor contatar o administrador.');
        }
        else{
            
            //CASO A NOTA PASSE, SERA SALVA NO BANCO DE DADOS
            $nfe = new nfe();
            $nfe->chaveNfe = $xml[1];
            $nfe->nNF = $xml[2];
            $hoje = date('d/m/Y');

            DB::table('nfe')->insert(
                ['chaveNF' => $xml[1], 'nNF' => $xml[2],'OF' => $nfe1['OF'], 'ID_cliente' =>$nfe1['ID_cliente'],'data_abertura' =>$hoje]
            );
        }

        $danfe = $nfeService->gerarDanfe($xml[1]);
        //DESCOMENTAR ESSA LINHA PARA VER A DANFE NA TELA e ir no metodo gerarDanfe()
        //dd($danfe);


        return redirect('admin/nfe/finalizarNfe');
        
    
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
        pedido::select(DB::raw('concat(OF) as text, pedido.ID_cliente as ID_cliente, c.nome as nome,c.cpf_cnpj as cpf_cnpj,c.email as email,c.inscricao_estadual as IE,c.uf as ufCli'))->join('cliente as c','c.ID_cliente','=','pedido.ID_cliente')
                    ->where("OF","LIKE","%{$request->input('query')}%")->where("firma",$firma)->where('c.ID_Cliente',DB::raw('pedido.ID_cliente'))->groupBy('OF')
                    ->get();
        return response()->json($produto_cliente);
        }

}
