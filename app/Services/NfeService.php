<?php 
    namespace App\Services;

    use DateTime;
    use Exception;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Storage;
use NFePHP\NFe\Make;
    use NFePHP\Common\Certificate;
    use NFePHP\Common\Keys;
    use NFePHP\NFe\Tools;
    use NFePHP\NFe\Common\Standardize;
    use NFePHP\NFe\Complements;
    use NFePHP\DA\NFe\Danfe;
    use stdClass;

class NfeService{

        private $config;
        private $tools;

        public function __construct($config){
 
            $this->config = $config;
            $certificadoDigital = file_get_contents('..\app\Services\certFM.pfx');
            $this->tools = new Tools(json_encode($config), Certificate::readPfx($certificadoDigital, '31083684'));
        }

        public function gerarNfe($nfe1,$nfe2,$nfe3,$datas,$transpo,$cliente,$nNFdb,$aliquota){
            //Criar Nota Fiscal Vazia
            $nfe = new Make();

            //====================TAG IDE===================
            $infNfe = new stdClass();
            $infNfe->versao = '4.00'; //versão do layout (string)
            $infNfe->Id = null; //se o Id de 44 digitos não for passado será gerado automaticamente
            $infNfe->pk_nItem = null; //deixe essa variavel sempre como NULL

            $respInfNfe = $nfe->taginfNFe($infNfe);

            //====================TAG IDE===================
            $ide = new stdClass();

            $ide->cUF = 35;
            $ide->nNF = $nNFdb;
            $ide->cNF =  STR_PAD($ide->nNF + 1, '0', 8, STR_PAD_LEFT); //rand(11111111,99999999);
            $ide->natOp = $nfe1['natOp'];

            //$stdIde->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00

            $ide->mod = 55;
            $ide->serie = 1;
            $ide->dhEmi = date('Y-m-d\TH:i:sP');
            $ide->dhSaiEnt = date('Y-m-d\TH:i:sP');
            $ide->tpNF = 1;  //Nota de entrada ou saida. 0-Entrada / 1-Saida
            if($cliente[0]->uf=='SP'){
                $dentroEstado = 1;
            }
            else{
                $dentroEstado = 2;
            }
            $ide->idDest = $dentroEstado; //Dentro ou fora do estado. 1-Dentro / 2-Fora
            $ide->cMunFG = 3538709;
            $ide->tpImp = 1; //Formato de Impressão da DANFE 1-Retrato / 2-Paisagem
            $ide->tpEmis = 1; 
            //$ide->cDV = 0; // Dígito Verificador da Chave de Acesso da NF-e
            $ide->tpAmb = 2; // Tipo de Ambiente. 1-Producao / 2-Homologacao
            $ide->finNFe = 1; // Finalidade de emissão da NF-e  1- NF-e normal/ 2-NF-e complementar / 3 – NF-e de ajuste
            $ide->indFinal = 1; // Consumidor Final ou não. 0-Não / 1-Sim
            $ide->indPres = 1; //Presenca do Consumidor na hora da emissao ou não. 0-Não / 1-Sim
            $ide->procEmi = 0;
            $ide->verProc = '4.00';
            //$ide->dhCont = null;
            //$ide->xJust = null;

            $respIde = $nfe->tagide($ide);


            //====================TAG EMITENTE===================
            $emit = new stdClass();
            $emit->xNome = 'FLEXMOL INDUSTRIA E COMERCIO DE MOLAS LTDA ME';
            //$emit->xFant;
            $emit->IE = '535338509117';
            //$emit->IEST;
            //$emit->IM ;
            //$emit->CNAE;
            $emit->CRT = '1';
            $emit->CNPJ = '04568351000154'; //indicar apenas um CNPJ ou CPF
            //$emit->CPF;

            $respEmit = $nfe->tagemit($emit);

            //====================TAG ENDERECO EMITENTE===================
            $enderEmit = new stdClass();
            $enderEmit->xLgr = 'RUA JOSE PASSARELA';
            $enderEmit->nro = '240';
            //$enderEmit->xCpl;
            $enderEmit->xBairro = 'JARDIM SAO JORGE';
            $enderEmit->cMun = '3538709';
            $enderEmit->xMun = 'Piracicaba';
            $enderEmit->UF = 'SP';
            $enderEmit->CEP = '13402705';
            $enderEmit->cPais = '1058';
            $enderEmit->xPais = 'Brasil';
            $enderEmit->fone = '1934345840';

            $respEnderEmit = $nfe->tagenderEmit($enderEmit);

            //====================TAG DESTINATARIO===================
            $dest = new stdClass();
            $dest->xNome = $nfe1['nomeCli'];
            $dest->indIEDest = '1';
            $dest->IE = $nfe1['ieCli'];
            //$dest->ISUF;
            //$dest->IM;
            $dest->email = $nfe1['emailCli'];
            $dest->CNPJ = $nfe1['cpf_cnpjCli']; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
            //$dest->CPF;
            //$dest->idEstrangeiro;

            $respDest = $nfe->tagdest($dest);

            //====================TAG ENDERECO DESTINATARIO===================
            $enderDest = new stdClass();
            $enderDest->xLgr = $cliente[0]->logradouro;
            $enderDest->nro = $cliente[0]->numero;
            //$enderDest->xCpl;
            $enderDest->xBairro = $cliente[0]->bairro;
            $enderDest->cMun = $cliente[0]->ibge;
            $enderDest->xMun = $cliente[0]->cidade;
            $enderDest->UF = $cliente[0]->uf;
            $enderDest->CEP = str_replace("-", "", $cliente[0]->cep);
            $enderDest->cPais = '1058';
            $enderDest->xPais = 'Brasil';
            $enderDest->fone = $cliente[0]->telefone;

            $respEnderDest = $nfe->tagenderDest($enderDest);

            //====================TAG PRODUTO===================
                for ($i=0; $i < $nfe2['totalQtde']; $i++) { 
                    # code...
                    $prod = new stdClass();
                    $prod->item = $i+1; //item da NFe
                    $prod->cProd = $nfe2['codFabriProd'][$i];
                    $prod->cEAN = 'SEM GTIN';
                    $prod->xProd = $nfe2['descricaoProd'][$i];
                    $prod->NCM = $nfe2['ncm'][$i];

                    //$prod->cBenef = null; //incluido no layout 4.00

                    //$prod->EXTIPI;
                    $prod->CFOP = $nfe1['natOp'];
                    $prod->uCom = 'PC'; //Unidade do produto
                    $prod->qCom = $nfe2['quantidade'][$i]; //Quantidade do produto
                    $prod->vUnCom = number_format($nfe2['precoProd'][$i] - (($nfe2['precoProd'][$i] * $nfe3['porcento'])/100),9); // Valor total - %desconto
                    $prod->cEANTrib = 'SEM GTIN';
                    $prod->uTrib = 'PC';
                    $prod->qTrib = $nfe2['quantidade'][$i];
                    $prod->vUnTrib = number_format($nfe2['precoProd'][$i] - (($nfe2['precoProd'][$i] * $nfe3['porcento'])/100),9); // Valor total - %desconto
                    $prod->vProd = number_format(($prod->qTrib * $prod->vUnTrib),2,'.',''); // Valor do produto = QUANTIDADE X Unidade Tributaria
                    //$prod->vFrete = 0.00;
                    //$prod->vSeg = 0.00;
                    //$prod->vDesc =  (($nfe2['precoProd'][$i] * $nfe3['porcento'])/100);
                    //$prod->vOutro = 0.00;
                    $prod->indTot = 1;
                    //$prod->xPed;         //Numero de pedido do cliente
                    //$prod->nItemPed;
                    //$prod->nFCI;

                    $respProd = $nfe->tagprod($prod);

                    //====================TAG INFORMACAO ADICIONAL PRODUTO===================
                    /*$adciProd = new stdClass();
                    $adciProd->item = 1; //item da NFe

                    $adciProd->infAdProd = 'informacao adicional do item';

                    $respAdiciProd = $nfe->taginfAdProd($adciProd);
                    */
                    //====================TAG IMPOSTO===================
                    $imposto = new stdClass();
                    $imposto->item = $i+1; //item da NFe
                    //$imposto->vTotTrib = 1000.00;

                    $respImposto = $nfe->tagimposto($imposto);

                    //====================TAG ICMS N101===================
                    $icms = new stdClass();
                    $icms->item = $i+1; //item da NFe
                    $icms->orig = 0;
                    $icms->CSOSN = '101';
                    $icms->pCredSN = $aliquota->aliquota;
                    $icms->vCredICMSSN = $nfe3['precoFinal'] * ($aliquota->aliquota/100);
                    //$icms->modBCST = null;
                    //$icms->pMVAST = null;
                    //$icms->pRedBCST = null;
                    //$icms->vBCST = null;
                    //$icms->pICMSST = null;
                    //$icms->vICMSST = null;
                    //$icms->vBCFCPST = null; //incluso no layout 4.00
                    //$icms->pFCPST = null; //incluso no layout 4.00
                    //$icms->vFCPST = null; //incluso no layout 4.00
                    //$icms->vBCSTRet = null;
                    //$icms->pST = null;
                    //$icms->vICMSSTRet = null;
                    //$icms->vBCFCPSTRet = null; //incluso no layout 4.00
                    //$icms->pFCPSTRet = null; //incluso no layout 4.00
                    //$icms->vFCPSTRet = null; //incluso no layout 4.00
                    //$icms->modBC = null;
                    //$icms->vBC = null;
                    //$icms->pRedBC = null;
                    //$icms->pICMS = null;
                    //$icms->vICMS = null;
                    //$icms->pRedBCEfet = null;
                    //$icms->vBCEfet = null;
                    //$icms->pICMSEfet = null;
                    //$icms->vICMSEfet = null;
                    //$icms->vICMSSubstituto = null;

                    $respIcms = $nfe->tagICMSSN($icms);

                    //====================TAG PIS===================
                    $pis = new stdClass();
                    $pis->item = $i+1; //item da NFe
                    $pis->CST = 99;
                    $pis->vBC = 0.00;
                    $pis->pPIS = 0.00;
                    $pis->vPIS = 0.00;
                    //$pis->qBCProd = null;
                    //$pis->vAliqProd = null;

                    $respPis = $nfe->tagPIS($pis);
                
                    //====================TAG COFINS===================
                    $cofis = new stdClass();
                    $cofis->item = $i+1; //item da NFe
                    $cofis->CST = 99;
                    $cofis->vBC = 0.00;
                    $cofis->pCOFINS = 0.00;
                    $cofis->vCOFINS = 0.00;
                    //$cofis->qBCProd = null;
                    //$cofis->vAliqProd = null;

                    $repsCofis = $nfe->tagCOFINS($cofis);
                }
                //====================TAG ICMSTOTAL===================
                $icmsTotal = new stdClass();
                $icmsTotal->vBC = 0.00;
                $icmsTotal->vICMS = 0.00;
                $icmsTotal->vICMSDeson = 0.00;
                $icmsTotal->vFCP = 0.00; //incluso no layout 4.00
                $icmsTotal->vBCST = 0.00;
                $icmsTotal->vST = 0.00;
                $icmsTotal->vFCPST = 0.00; //incluso no layout 4.00
                $icmsTotal->vFCPSTRet = 0.00; //incluso no layout 4.00
                $icmsTotal->vProd = number_format($nfe3['precoFinal'],2,'.','');
                $icmsTotal->vFrete = 0.00;
                $icmsTotal->vSeg = 0.00;
                $icmsTotal->vDesc = 0.00;
                $icmsTotal->vII = 0.00;
                $icmsTotal->vIPI = 0.00;
                $icmsTotal->vIPIDevol = 0.00; //incluso no layout 4.00
                $icmsTotal->vPIS = 0.00;
                $icmsTotal->vCOFINS = 0.00;
                $icmsTotal->vOutro = 0.00;
                $icmsTotal->vNF = $nfe3['precoFinal'];
                //$icmsTotal->vTotTrib = 0.00;

                $repsIcmsTotal = $nfe->tagICMSTot($icmsTotal);

                //====================TAG TRANSP===================
                $transp = new stdClass();
                $transp->modFrete = $nfe1['modFrete']; //0-Por conta do emitente; 1-Por conta do destinatário/remetente; 2-Por conta de terceiros; 9-Sem frete. (V2.0)
                

                $respTransp = $nfe->tagtransp($transp);

                //====================TAG TRANSPORTADORA===================
                $transportadora = new stdClass();
                $transportadora->xNome = $nfe1['nomeTransp'];
                $transportadora->IE = $transpo[0]->inscricao_estadual;
                $transportadora->xEnder = $transpo[0]->logradouro;
                $transportadora->xMun = $transpo[0]->cidade;
                $transportadora->UF = $transpo[0]->uf;
                $transportadora->CNPJ = $nfe1['cpf_cnpjTransp'];//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
                //$transportadora->CPF = null;

                $respTransportadora = $nfe->tagtransporta($transportadora);

                //====================TAG VOLUME===================
                $vol = new stdClass();
                //$vol->item = 1; //indicativo do numero do volume
                $vol->qVol = $nfe3['qtdeComp'];
                $vol->esp = $nfe3['especie'];
                $vol->marca = 'MARCA';
                //$vol->nVol = '11111';
                $vol->pesoL = $nfe3['pesoLiq'];
                $vol->pesoB = $nfe3['pesoBruto'];

                $respVol = $nfe->tagvol($vol);

                //====================TAG FATURA===================
                $fat = new stdClass();
                $fat->nFat = $ide->nNF;
                $fat->vOrig = number_format($nfe2['total'],9,'.','');
                $fat->vDesc = number_format($nfe3['desconto'],9,'.','');
                $fat->vLiq = number_format($nfe3['precoFinal'],9,'.','');

                $respFat = $nfe->tagfat($fat);
                //====================TAG DUPLICATA===================    
                //dd($fat->vLiq); 
                $diff = $fat->vLiq - (round($nfe3['precoFinal']/$nfe1['numParc'],9)) * $nfe1['numParc'];
                $diff = round($diff,9);
                for ($i=0; $i < $nfe1['numParc']; $i++) { 
                    # code...
                
                    $dup = new stdClass();
                    $dup->nDup = '00'.($i+1);
                    $dup->dVenc = $datas[$i];
                    $dup->vDup = $nfe3['precoFinal']/$nfe1['numParc'];
                    // IF para adicionar o centavos na ultima parcela se necessario
                    if($i == $nfe1['numParc']-1){

                        $dup->vDup += $diff;
                    }
                    $respDup = $nfe->tagdup($dup);

                    
                }
                //====================TAG PAGAMENTO===================
                $pag = new stdClass();
                //$std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)

                $respPag = $nfe->tagpag($pag);

                //====================TAG DETALHE PAGAMENTO===================
                $detPag = new stdClass();
                $detPag->tPag = '15';
                $detPag->vPag = $nfe3['precoFinal']; //Obs: deve ser informado o valor pago pelo cliente
                //$detPag->CNPJ = '12345678901234';
                //$detPag->tBand = '01';
                //$detPag->cAut = '3333333';
                //$detPag->tpIntegra = 1; //incluso na NT 2015/002
                //$detPag->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

                $respDetPag = $nfe->tagdetPag($detPag);

                //====================INFO ADICIONAL===================
                $stdInfo = new stdClass();
                $stdInfo->infAdFisco = $nfe3['infoAdc'] ?? "DOCUMENTO EMITIDO POR ME OU EPP OPTANTE PELO SIMPLES NACIONAL, CONFORME LEI COMPLEMENTAR 123/2006 II - NAO GERA DIREITO A CREDITO FISCAL DE IPI. III - PERMITE O APROVEITAMENTO DO CREDITO DE ICMS NO VALOR DE R$ ".number_format($nfe3['precoFinal'] * ($aliquota->aliquota/100),2,',')." CORRESPONDENTE A ALIQUOTA DE ".number_format($aliquota->aliquota,6,',').", NOS TERMOS DO ART. 23 DA LC 123/2006";
                //$std->infCpl = 'informacoes complementares';

                $nfe->taginfAdic($stdInfo);

                //====================MONTA A NOTA FISCAL ====================

                $erros = $nfe->getErrors();
                //$chave = $nfe->getChave();
                $resp = array();
                $xml = $nfe->monta();
                //=== CODIGO PARA GERAR O CÓDIGO DA NFE
                $mes = date('m');
                $ano = date('y');
                $cNFcomZero = STR_PAD($ide->nNF, 9, '0', STR_PAD_LEFT);               
                //$chave = $ide->cUF.$ano.$mes.$emit->CNPJ.$ide->mod.'00'.$ide->serie.$cNFcomZero.$ide->tpEmis.$ide->cNF.'0';
                $chave = Keys::build($ide->cUF, $ano, $mes, $emit->CNPJ, $ide->mod, $ide->serie, $ide->nNF, $ide->tpEmis, $ide->cNF);
                //=== COLOCA O XML E A CHAVE NO ARRAY DE RETORNO
                array_push($resp,$xml);
                array_push($resp,$chave);
                array_push($resp,$ide->nNF);
                // DECOMENTAR PARA VER SE A CHAVE É IGUAL A NOTA 
                //dd($chave,$nfe->getChave());
                
                return $resp;
                
        }

        public function assinar($xml){
            $xmlSigned = $this->tools->signNFe($xml);
            return $xmlSigned;
        }

        public function transmitir($xmlSigned,$chave){
            //Envia o lote
            $resp = $this->tools->sefazEnviaLote([$xmlSigned], 1);

            $st = new Standardize();
            $std = $st->toStd($resp);
            if ($std->cStat != 103) {
                //erro registrar e voltar
                exit("[$std->cStat] $std->xMotivo");
            }
            $recibo = $std->infRec->nRec; // Vamos usar a variável $recibo para consultar o status da nota
            
            $protocolo = $this->tools->sefazConsultaRecibo($recibo);
            //return($protocolo);

            //Protocola o recibo no XML
            $request = $xmlSigned;
            $response = $protocolo;
            
            try {
                $xmlFinal = Complements::toAuthorize($request, $response);

                //"{cnpj}/nfe/homologacao/2020-08/{chave}.xml";

                $mes = date('m');
                $ano = date('Y');
                //header('Content-type: text/xml; charset=UTF-8');
                //file_put_contents('storage/'.$mes.$ano.'/'.$chave.'.xml',$xmlFinal);
                Storage::put('Nfe/'.$mes.'-'.$ano.'/'.$chave.'.xml', $xmlFinal);
                //Storage::putFile('uploadedFile',  new File('/path/to/file'));
                
                $path = 'Nfe/'.$mes.'-'.$ano.'/'.$chave;
                session(['path_nfe' => $path]);
                $xmlFinal1 = Storage::get('Nfe/'.$mes.'-'.$ano.'/'.$chave.'.xml');
                
                return $xmlFinal1;
            } catch (\Exception $e) {
                echo "Erro Protocolo: " . $e->getMessage();
            }


        }

        //GERAR A DANFE
        public function gerarDanfe($chave){
            $mes = date('m');
            $ano = date('Y');
            $xml = Storage::get('Nfe/'.$mes.'-'.$ano.'/'.$chave.'.xml');
            
            $logo = 'data://text/plain;base64,'. base64_encode(file_get_contents("logoFM.jpg"));;

            try {
                $danfe = new Danfe($xml);
                $danfe->debugMode(false);
                $danfe->creditsIntegratorFooter('FlexCode - By Matheus Filho');
                // Caso queira mudar a configuracao padrao de impressao
                /*  $this->printParameters( $orientacao = '', $papel = 'A4', $margSup = 2, $margEsq = 2 ); */
                //Informe o numero DPEC
                /*  $danfe->depecNumber('123456789'); */
                //Configura a posicao da logo
                /*  $danfe->logoParameters($logo, 'C', false);  */
                //Gera o PDF
                $pdf = $danfe->render($logo);
                Storage::put('Nfe/'.$mes.'-'.$ano.'/'.$chave.'.pdf', $pdf);
                
               
                //DESCOMENTAR AS DUAS LINHAS ABAIXO PARA MOSTRAR A DANFE
                //header('Content-Type: application/pdf');
                //echo $pdf;
            } catch (Exception $e) {
                echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
            }  
            
        }

        //FUNCOES EXTRAS
        public function format($numero,$dec = 2){
            return number_format($numero,$dec,'.','');
        }
        

    }


?>