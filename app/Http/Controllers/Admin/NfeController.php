<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\nfe;
use App\Models\cliente;
use App\Models\pedido;
use App\Services\NfeService;
use App\Services\NfeServiceMF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NfeMail;
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
        $request->session()->forget('path_nfe');
       
        $firma = Auth::user()->firma;
        $nfe = DB::table('nfe as n')->join('cliente as c','n.ID_cliente','=','c.ID_cliente')->select('n.ID_nfe','n.OF','n.nNF', 'n.chaveNF', 'c.nome','n.data_abertura')->where('firma',$firma)->orderBy('ID_nfe', 'desc')->get();
        
        return view('admin.nfe.index',compact('nfe','firma'));
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
        $nfe = new nfe();
        $cliente = new cliente();

        $nfe = $nfe->find($id);
        $cliente = $cliente->find($nfe->ID_cliente);

        $firma = Auth::user()->firma;

        return view('admin.nfe.show',compact('nfe','firma','cliente'));
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
        $firma = Auth::user()->firma;
        $nfe = $request->session()->get('nfe1');

        if($firma == 'FM')
            return view('admin.nfe.emitirPasso1',compact('nfe'));
        else
            return view('admin.nfemf.emitirPasso1',compact('nfe'));
        
    }

    public function postEmitir1(Request $request)
    {
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        //dd($dataFormNfe);
        $firma = Auth::user()->firma;
        
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

        if($firma == 'FM')
            return redirect('admin/nfe/emitirPasso2');
        else
            return redirect('admin/nfemf/emitirPasso2');
    }

    //=================EMITIR PASSO 2 ==================
    public function emitir2(Request $request)
    {
        $produto = $request->session()->get('nfe1');
        $of = $produto['OF'];
        $produtosNota = array();
        $produtosNota2 = array();
        $quantidades = array();
        $firma = Auth::user()->firma;

        $pedido = DB::table('pedido as p')->select('p.codigo','p.quantidade')->where('p.OF', $of)->where('p.firma', $firma)->get()->toArray();
        
        // =========== TRAZENDO TODAS AS INFOS DE PRODUTOS ===============
        foreach ($pedido as $key => $value) {
            $produtoCli = DB::table('produto_cliente as p')->select('p.cod_fabricacao','p.descricao','p.ncm','p.preco_venda','p.cfop','p.unidade_saida')->where('p.cod_fabricacao', $pedido[$key]->codigo)->where('p.firma', $firma)->get()->toArray();
            array_push($produtosNota,$produtoCli);   
        }
        //DESCOMENTAR PARA VER A LISTA DE PRODUTOS DA OF
        //dd($produtosNota);
        foreach ($pedido as $key => $value) {
            $qtde = DB::table('pedido as p')->select('p.codigo','p.quantidade')->where('p.OF', $of)->where('p.firma', $firma)->get()->toArray();
            array_push($quantidades,$qtde[$key]->quantidade);  
        }
        
        foreach ($produtosNota as $key => $value) {
            array_push($produtosNota2,$produtosNota[$key][0]);    
        }
        //dd($produtosNota2);
        $produtos = $produtosNota2;
        

        if($firma == 'FM')
            return view('admin.nfe.emitirPasso2',compact('produtos','quantidades','firma'));
        else
            return view('admin.nfemf.emitirPasso2',compact('produtos','quantidades','firma'));
        }
    public function postEmitir2(Request $request)
    {
        $firma = Auth::user()->firma;
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormNfe);

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

        if($firma == 'FM')
            return redirect('admin/nfe/emitirPasso3');
        else
            return redirect('admin/nfemf/emitirPasso3');
        
    }

    //=================EMITIR PASSO 3 ==================
    public function emitir3(Request $request)
    {
        $firma = Auth::user()->firma;
        $nfe3 = $request->session()->get('nfe3');
        $nfe2 = $request->session()->get('nfe2');
        $nfe1 = $request->session()->get('nfe1');
        
        if($firma == 'FM')
            return view('admin.nfe.emitirPasso3',compact('nfe3','nfe2','nfe1'));
        else   
            return view('admin.nfemf.emitirPasso3',compact('nfe3','nfe2','nfe1')); 
    }   
    public function postEmitir3(Request $request)
    {
        $firma = Auth::user()->firma;
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

        if($firma=='FM'){
            $nfeService = new NfeService([
                "atualizacao" => "2015-10-02 06:01:21",
                "tpAmb" => 1,
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
        }
        else{
            $nfeService = new NfeServiceMF([
                "atualizacao" => "2015-10-02 06:01:21",
                "tpAmb" => 2,
                "razaosocial" => "METALFLEX INDUSTRIA E COMERCIO DE MOLAS LTDA ME",
                "siglaUF" => "SP",
                "cnpj" => "13971196000103",
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
        }

        $nfe1 = $request->session()->get('nfe1');
        $nfe2 = $request->session()->get('nfe2');
        $nfe3 = $request->session()->get('nfe3');
        $datas = $request->session()->get('datas');
        $transp = $request->session()->get('transp');
        $cliente = $request->session()->get('cliente');
        $firma = Auth::user()->firma;
        $nfeCad = new nfe();
        $clienteCad= new cliente();
        
        $data = $request->session()->all();

        //DESCOMENTAR ESSA LINHA PARA VER O ARMAZENAMENTO DA SESSION
        //dd($data);

        
        $ultimo = DB::table('nfe')->where('firma',$firma)->orderBy('ID_nfe', 'desc')->first();
        if($firma == 'FM')
            $aliquota = DB::table('aliquota')->first();
        else
            $aliquota = DB::table('aliquota')->orderBy('ID_aliquota','desc')->first();
        
        //dd($aliquota);
        $nNFdb = $ultimo->nNF+1;
        
        
        $xml = $nfeService->gerarNfe($nfe1,$nfe2,$nfe3,$datas,$transp,$cliente,$nNFdb,$aliquota);
        //dd($xml[0]);
        //dd($xml); $xml[0] -Nfe  /  $xml[1] -chaveNfe  /  $xml[2] -nNF
        $xmlAssinada = $nfeService->assinar($xml[0]);

        //DESCOMENTAR ESSA LINHA PARA VER A VALIDACAO DO XML NO SEFAZ
        //dd($xmlAssinada);

        $xmlEnviada = $nfeService->transmitir($xmlAssinada,$xml[1]);
        //DESCOMENTAR ESSA LINHA PARA VER O SE ESTÁ FUNFANDO A XML
        //dd($xmlEnviada);

        $path_nfe = $request->session()->get('path_nfe');
        //dd($path_nfe);
        if ($xmlEnviada['situacao'] == 'rejeitada' || $xmlEnviada['situacao'] == 'denegada') {
             //CASO A NOTA SEJA REJEITADA 
             dd('Nota fiscal com erro: ' . $xmlEnviada['motivo']);
            return redirect('admin/nfe')->with('error', 'Nada foi feito, NFe com problema, favor contatar o administrador. '.$xmlEnviada);
        }
        else{
            $path_nfe = $request->session()->get('path_nfe');
            //CASO A NOTA PASSE, SERA SALVA NO BANCO DE DADOS
            $nfe = new nfe();
            $nfe->chaveNfe = $xml[1];
            $nfe->nNF = $xml[2];
            $hoje = date('d/m/Y');

            DB::table('nfe')->insert(
                ['chaveNF' => $xml[1], 'nNF' => $xml[2],'OF' => $nfe1['OF'], 'ID_cliente' =>$nfe1['ID_cliente'],'data_abertura' =>$hoje,'path_nfe' => $path_nfe, 'firma' => $firma]
            );

        }

        $danfe = $nfeService->gerarDanfe($xml[1]);
        //DESCOMENTAR ESSA LINHA PARA VER A DANFE NA TELA e ir no metodo gerarDanfe()
        //dd($danfe);

        
        DB::table('faturamento')->insert(
        [   'vale' => $nfe1['OF'],
            'nfe' => $xml[2],
            'situacao' => 'Fechado',
            'cliente' =>$nfe1['ID_cliente'],
            'peso' =>$nfe3['pesoLiq'],
            'valor' => $nfe3['precoFinal']+$nfe1['valorFrete'],
            'firma' => 'FM',
            'status' => 'Pago'
        ]
        );

        //================== ADICIONANDO EVENTO MONEY ===============================

        $valorOriginal = number_format($nfe2['total']+$nfe1['valorFrete'],2,'.','');
        $valorDesconto = number_format($nfe3['desconto'],2,'.','');
        $valorLiquido = $valorOriginal - $valorDesconto;

        $diff = number_format(($nfe3['precoFinal']+$nfe1['valorFrete'])/$nfe1['numParc'],2,'.','');
        $diff = number_format($valorLiquido - $diff*$nfe1['numParc'],2);

        for ($i = 0; $i < $nfe1['numParc']; $i++){
            $valor = ($nfe3['precoFinal']+$nfe1['valorFrete'])/$nfe1['numParc']; 

            if($i == $nfe1['numParc']-1){

                $valor += $diff;
            }
            DB::table('evento')->insert(
            [
                'title' =>'- Aberto', 
                'start' => $datas[$i],
                'color' => '#8cf19f', 
                'valor' =>$valor,
                'ID_cliente' =>$nfe1['ID_cliente'],
                'favorecido' => $nfe1['nomeCli'],
                'tipoFav' => 'cliente',
                'situacao' => 'on',
                'ID_banco' => 2,
                'firma' => 'FM',
                'description' => 'NFe: '.$xml[2].' - '.($i+1)
            ]
            );
        }

        return redirect('admin/nfe')->with('success', 'Sucesso, NFe criada! Clique na primeira linha da tabela para exibi-la.');
        
    
    }





    public function addParcela(Request $request){
        $dataFormNfe = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $request->session()->put('datas', $dataFormNfe['datas']);
        
    }

    public function enviarEmail(Request $request){
        $dataFormMail = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        
        if(isset($dataFormMail['email'])){
            $nfe = new nfe();
            $cliente = new cliente();
            

            $nfe = $nfe->find($dataFormMail['ID_nfe']);
            $cliente = $cliente->find($dataFormMail['ID_cliente']);

            $nfe = $nfe->getAttributes();
            $cliente = $cliente->getAttributes();

            $mail = new NfeMail($nfe,$cliente);
            $mail->enviarEmailCli();
            $mail->enviarEmailProprio();
            
            return back()->with('success', 'Email enviado com sucesso!');
        }
        else{
            return back()->with('error', 'Função indisponível no momento!');
        }
    }
    public function inutilizarShow(){
        return view('admin.nfe.inutilizar');
    }
    public function inutilizar(Request $request){

        $nfeService = new NfeService([
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 1,
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

        $configu = [
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 1,
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
        ];

        $nfeService->inutilizaNfe($configu);
    }


    public function cartaCorrecao(Request $request){
        $dataFormCorrecao = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormCorrecao);
        $chave = $dataFormCorrecao['chaveNF'];
        $just = $dataFormCorrecao['just'];
        $nSeq = $dataFormCorrecao['nSeqEvento'];
        $idNfe = $dataFormCorrecao['idNfe'];
        $nfeService = new NfeService([
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 1,
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

        $configu = [
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 1,
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
        ];

        $resp = $nfeService->corrigirNfe($configu,$chave,$just,$nSeq);
        $respPdf = $nfeService->gerarCartaCorrecaoPdf($chave);
        
        if($resp == 1){
            DB::table('nfe')->where('ID_nfe', $idNfe)->update(['nSeqEvento' => $nSeq+1]);
            return back()->with('success', 'Carta de Correção Protocolada!');
        }
        else{
            return back()->with('error', 'Carta de Correção Rejeitada!');
        }
        
        

    }

    public function cancelar(Request $request){
        $dataFormCancelar = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormCancelar);
        $chave = $dataFormCancelar['chaveNF'];
        $just = $dataFormCancelar['just'];
        $protocolo = $dataFormCancelar['protocolo'];
        $idNfe = $dataFormCancelar['idNfe'];
        $nfeService = new NfeService([
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 1,
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

        $configu = [
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 1,
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
        ];
        
        $resp = $nfeService->cancelarNfe($configu,$chave,$just,$protocolo);
        if($resp == 1){
            return back()->with('success', 'Carta de Correção Protocolada!');
        }
        else{
            return back()->with('error', 'Carta de Correção Rejeitada!');
        }
        
        

    }

    public function autocompleteCodigoProdNfe(Request $request){
        
        $firma = Auth::user()->firma;
        $produto_cliente = 
        pedido::select(DB::raw('concat(OF) as text, pedido.ID_cliente as ID_cliente, c.nome as nome,c.cpf_cnpj as cpf_cnpj,c.email as email,c.inscricao_estadual as IE,c.uf as ufCli'))->join('cliente as c','c.ID_cliente','=','pedido.ID_cliente')
                    ->where("OF","LIKE","%{$request->input('query')}%")/*->where("status",'Fechado')*/->where("firma",$firma)->where('c.ID_Cliente',DB::raw('pedido.ID_cliente'))->groupBy('OF')
                    ->get();
        return response()->json($produto_cliente);
        }

    
    
}
