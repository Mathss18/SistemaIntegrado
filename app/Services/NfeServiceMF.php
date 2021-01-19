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
use NFePHP\DA\NFe\Daevento;
use stdClass;
use Auth;

class NfeServiceMF
{

    private $config;
    private $tools;

    public function __construct($config)
    {

        $this->config = $config;
        $certificadoDigital = file_get_contents('..\app\Services\certMF.pfx');
        $this->tools = new Tools(json_encode($config), Certificate::readPfx($certificadoDigital, '01111972'));
        $this->tools->model(55);
    }

    public function gerarNfe($nfe1, $nfe2, $nfe3, $datas, $transpo, $cliente, $nNFdb, $aliquota)
    {
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
        $ide->nNF = $nNFdb; //99909
        $ide->cNF =  STR_PAD($ide->nNF + 1, '0', 8, STR_PAD_LEFT); //rand(11111111,99999999);
        $cfopRetorno = $nfe1['natOp'];
        if ($nfe1['natOp'] == "6101") {
            $ide->natOp = $nfe1['natOp'] . "- Vendas Fora do Estado";
        } else if ($nfe1['natOp'] == "5101") {
            $ide->natOp = $nfe1['natOp'] . "- Vendas Dentro do Estado";
        } else if ($nfe1['natOp'] == "5902") {
            $ide->natOp = $nfe1['natOp'] . "- Retorno De Mercadoria";
        } else if ($nfe1['natOp'] == "5124") {
            $ide->natOp = $nfe1['natOp'] . "- Industrializacao";
        } else if ($nfe1['natOp'] == "5901") {
            $ide->natOp = $nfe1['natOp'] . "- Remessa para Industrializacao por Encomenda";
        } else if ($nfe1['natOp'] == "5921") {
            $ide->natOp = $nfe1['natOp'] . "- Retorno de Embalagem";
        }
        else if($nfe1['natOp'] == "6912"){
            $ide->natOp = $nfe1['natOp']."- Remessa de mercadoria para demonstração";
        }
        else if($nfe1['natOp'] == "6910"){
            $ide->natOp = $nfe1['natOp']."- Remessa em bonificação, doação ou brinde";
        }
         else {
            $ide->natOp = $nfe1['natOp'];
        }
        //$ide->natOp = $nfe1['natOp'];

        //$stdIde->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00

        $ide->mod = 55;
        $ide->serie = 1;
        $ide->dhEmi = date('Y-m-d\TH:i:sP');
        $ide->dhSaiEnt = date('Y-m-d\TH:i:sP');
        $ide->tpNF = 1;  //Nota de entrada ou saida. 0-Entrada / 1-Saida
        if ($cliente[0]->uf == 'SP') {
            $dentroEstado = 1;
        } else {
            $dentroEstado = 2;
        }
        $ide->idDest = $dentroEstado; //Dentro ou fora do estado. 1-Dentro / 2-Fora
        $ide->cMunFG = 3538709;
        $ide->tpImp = 1; //Formato de Impressão da DANFE 1-Retrato / 2-Paisagem
        $ide->tpEmis = 1;
        //$ide->cDV = 0; // Dígito Verificador da Chave de Acesso da NF-e
        $ide->tpAmb = 1; // Tipo de Ambiente. 1-Producao / 2-Homologacao
        $ide->finNFe = $nfe1['finNFe']; // Finalidade de emissão da NF-e  1- NF-e normal/ 2-NF-e complementar / 3 – NF-e de ajuste
        $ide->indFinal = 1; // Consumidor Final ou não. 0-Não / 1-Sim
        $ide->indPres = 1; //Presenca do Consumidor na hora da emissao ou não. 0-Não / 1-Sim
        $ide->procEmi = 0;
        $ide->verProc = '4.00';
        //$ide->dhCont = null;
        //$ide->xJust = null;

        $respIde = $nfe->tagide($ide);


        //====================TAG EMITENTE===================
        $emit = new stdClass();
        $emit->xNome = 'METALFLEX INDUSTRIA E COMERCIO DE MOLAS LTDA M';
        //$emit->xFant;
        $emit->IE = '535268096113';
        //$emit->IEST;
        //$emit->IM ;
        //$emit->CNAE;
        $emit->CRT = '1';
        $emit->CNPJ = '13971196000103'; //indicar apenas um CNPJ ou CPF
        //$emit->CPF;

        $respEmit = $nfe->tagemit($emit);

        //====================TAG ENDERECO EMITENTE===================
        $enderEmit = new stdClass();
        $enderEmit->xLgr = 'RUA PRINCESA ISABEL';
        $enderEmit->nro = '70';
        //$enderEmit->xCpl;
        $enderEmit->xBairro = 'JARDIM PACAEMBU';
        $enderEmit->cMun = '3538709';
        $enderEmit->xMun = 'Piracicaba';
        $enderEmit->UF = 'SP';
        $enderEmit->CEP = '13424586';
        $enderEmit->cPais = '1058';
        $enderEmit->xPais = 'Brasil';
        $enderEmit->fone = '1934227978';

        $respEnderEmit = $nfe->tagenderEmit($enderEmit);

        //====================TAG DESTINATARIO===================
        $dest = new stdClass();
        $dest->xNome = $this->tirarAcentos($nfe1['nomeCli']);
        //dd($dest->xNome);
        // VERIFICA SE O DEST É ISENTO DE ICMS, OU SEJA SEM INSCRICAO ESTADUAL
        if (strtoupper($nfe1['ieCli']) == 'ISENTO2') {

            $dest->indIEDest = '2';
            $dest->IE = null;
        } else if (strtoupper($nfe1['ieCli']) == 'ISENTO9') {
            $dest->indIEDest = '9';
            $dest->IE = null;
        } else if (strtoupper($nfe1['ieCli']) == 'ISENTO') {
            $dest->indIEDest = '2';
            $dest->IE = null;
        } else {
            $dest->indIEDest = '1';
            $dest->IE = $nfe1['ieCli'];
        }
        //$dest->ISUF;
        //$dest->IM;
        $dest->email = $nfe1['emailCli'];
        if (strlen($nfe1['cpf_cnpjCli']) == 14) {
            $dest->CNPJ = $nfe1['cpf_cnpjCli'];
        } else {
            $dest->CPF = $nfe1['cpf_cnpjCli'];
        }
        //$dest->CNPJ = $nfe1['cpf_cnpjCli']; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
        //$dest->CPF;
        //$dest->idEstrangeiro;

        $respDest = $nfe->tagdest($dest);


        //====================TAG ENDERECO DESTINATARIO===================
        $enderDest = new stdClass();
        $enderDest->xLgr = $this->tirarAcentos($cliente[0]->logradouro);
        $enderDest->nro = $cliente[0]->numero;
        //$enderDest->xCpl;
        $enderDest->xBairro = $this->tirarAcentos($cliente[0]->bairro);
        $enderDest->cMun = $cliente[0]->ibge;
        $enderDest->xMun = $this->tirarAcentos($cliente[0]->cidade);
        $enderDest->UF = $cliente[0]->uf;
        $enderDest->CEP = str_replace("-", "", $cliente[0]->cep);
        $enderDest->cPais = '1058';
        $enderDest->xPais = 'Brasil';
        $enderDest->fone = $cliente[0]->telefone;

        $respEnderDest = $nfe->tagenderDest($enderDest);

        //====================TAG PRODUTO===================
        for ($i = 0; $i < $nfe2['totalQtde']; $i++) {
            # code...
            $prod = new stdClass();
            $prod->item = $i + 1; //item da NFe
            $prod->cProd = $nfe2['codFabriProd'][$i];
            $prod->cEAN = 'SEM GTIN';
            $prod->xProd = $nfe2['descricaoProd'][$i];
            $prod->NCM = $nfe2['ncm'][$i];

            //$prod->cBenef = null; //incluido no layout 4.00

            //$prod->EXTIPI;
            $prod->CFOP = $nfe2['cfop'][$i];
            $prod->uCom = $nfe2['unidade'][$i]; //Unidade do produto
            $prod->qCom = $nfe2['quantidade'][$i]; //Quantidade do produto
            $prod->vUnCom = number_format($nfe2['precoProd'][$i] - (($nfe2['precoProd'][$i] * $nfe3['porcento']) / 100), 9,'.',''); // Valor total - %desconto
            $prod->cEANTrib = 'SEM GTIN';
            $prod->uTrib = $nfe2['unidade'][$i];
            $prod->qTrib = (int)$nfe2['quantidade'][$i];
            $prod->vUnTrib = number_format($nfe2['precoProd'][$i] - (($nfe2['precoProd'][$i] * $nfe3['porcento']) / 100), 9,'.',''); // Valor total - %desconto
            //dd($prod->vUnTrib);
            $prod->vProd = number_format(($prod->qTrib * $prod->vUnTrib), 2, '.', ''); // Valor do produto = QUANTIDADE X Unidade Tributaria
            if ($nfe1['valorFrete'] > 0.00) {
                $diffFrete = number_format($nfe1['valorFrete'] / $nfe2['totalQtde'], 2, '.', '');
                if ($i == $nfe2['totalQtde'] - 1) {
                    $prod->vFrete = number_format($nfe1['valorFrete'], 2, '.', '');
                    //$prod->vFrete = number_format(($nfe1['valorFrete']/$nfe2['totalQtde']),2,'.','');
                }
            }
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
            $imposto->item = $i + 1; //item da NFe
            //$imposto->vTotTrib = 1000.00;

            $respImposto = $nfe->tagimposto($imposto);

            //====================TAG ICMS N101===================
            $icms = new stdClass();
            $icms->item = $i + 1; //item da NFe
            $icms->orig = 0;
            if ($nfe1['natOp'] == 5902 || $nfe1['natOp'] == 6912 || $nfe1['natOp'] == 6910 || $dest->indIEDest == 2 || $dest->indIEDest == 9)
                $icms->CSOSN = '400';
            else if ($nfe1['natOp'] == 5124)
                $icms->CSOSN = '900';
            else if ($nfe1['natOp'] == 5921)
                $icms->CSOSN = '900';
            else
                $icms->CSOSN = '101';
            $icms->pCredSN = $aliquota->aliquota;
            $icms->vCredICMSSN = $nfe3['precoFinal'] * ($aliquota->aliquota / 100);
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

            //====================TAG IPI===================
            if ($nfe1['natOp'] == 5902) {
                $std = new stdClass();
                $std->item = $i + 1; //item da NFe
                $std->clEnq = null;
                $std->CNPJProd = null;
                $std->cSelo = null;
                $std->qSelo = null;
                $std->cEnq = '999';
                $std->CST = '53';
                $std->vIPI = 0.00;
                $std->vBC = 0.00;
                $std->pIPI = 0.00;
                $std->qUnid = null;
                $std->vUnid = null;

                $nfe->tagIPI($std);
            }
            //====================TAG PIS===================
            $pis = new stdClass();
            $pis->item = $i + 1; //item da NFe
            $pis->CST = 99;
            $pis->vBC = 0.00;
            $pis->pPIS = 0.00;
            $pis->vPIS = 0.00;
            //$pis->qBCProd = null;
            //$pis->vAliqProd = null;

            $respPis = $nfe->tagPIS($pis);

            //====================TAG COFINS===================
            $cofis = new stdClass();
            $cofis->item = $i + 1; //item da NFe
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
        $icmsTotal->vProd = number_format($nfe3['precoFinal'], 2, '.', '');
        $icmsTotal->vFrete = $nfe1['valorFrete'];
        $icmsTotal->vSeg = 0.00;
        $icmsTotal->vDesc = 0.00;
        $icmsTotal->vII = 0.00;
        $icmsTotal->vIPI = 0.00;
        $icmsTotal->vIPIDevol = 0.00; //incluso no layout 4.00
        $icmsTotal->vPIS = 0.00;
        $icmsTotal->vCOFINS = 0.00;
        $icmsTotal->vOutro = 0.00;
        $icmsTotal->vNF = $nfe3['precoFinal'] + $nfe1['valorFrete'];
        //$icmsTotal->vTotTrib = 0.00;

        $repsIcmsTotal = $nfe->tagICMSTot($icmsTotal);

        //====================TAG TRANSP===================
        $transp = new stdClass();
        $transp->modFrete = $nfe1['modFrete']; //0-Por conta do emitente; 1-Por conta do destinatário/remetente; 2-Por conta de terceiros; 9-Sem frete. (V2.0)


        $respTransp = $nfe->tagtransp($transp);

        //====================TAG TRANSPORTADORA===================
        if ($nfe1['nomeTransp'] != null ||  $nfe1['nomeTransp'] != '') {
            $transportadora = new stdClass();
            $transportadora->xNome = $this->tirarAcentos($nfe1['nomeTransp']);
            $transportadora->IE = $transpo[0]->inscricao_estadual;
            $transportadora->xEnder = $this->tirarAcentos($transpo[0]->logradouro);
            $transportadora->xMun = $transpo[0]->cidade;
            $transportadora->UF = $transpo[0]->uf;
            $transportadora->CNPJ = $nfe1['cpf_cnpjTransp']; //só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
            //$transportadora->CPF = null;

            $respTransportadora = $nfe->tagtransporta($transportadora);
        }

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

        //VERIFICA SE HÁ PARCELAS NA NOTA
        if ($nfe1['numParc'] >= 1) {
            //====================TAG FATURA===================
            $fat = new stdClass();
            $fat->nFat = $ide->nNF;
            $fat->vOrig = number_format($nfe2['total'] + $nfe1['valorFrete'], 2, '.', '');
            $fat->vDesc = number_format($nfe3['desconto'], 2, '.', '');
            $fat->vLiq =  $fat->vOrig - $fat->vDesc;
            //dd($fat->vOrig,$fat->vDesc, $fat->vOrig-$fat->vDesc);
            $respFat = $nfe->tagfat($fat);
            //====================TAG DUPLICATA===================   


            $diff = number_format(($nfe3['precoFinal'] + $nfe1['valorFrete']) / $nfe1['numParc'], 2, '.', '');

            $diff = number_format($fat->vLiq - $diff * $nfe1['numParc'], 2);

            for ($i = 0; $i < $nfe1['numParc']; $i++) {

                $dup = new stdClass();

                $dup->nDup = str_pad($i + 1, 3, "0", STR_PAD_LEFT);
                $dup->dVenc = $datas[$i];
                $dup->vDup = ($nfe3['precoFinal'] + $nfe1['valorFrete']) / $nfe1['numParc'];
                // IF para adicionar o centavos na ultima parcela se necessario
                if ($i == $nfe1['numParc'] - 1) {

                    $dup->vDup += $diff;
                }
                $respDup = $nfe->tagdup($dup);
            }

            // VALORES DISTINTOS DE DUPLICATA (MANUAL)
            /*
                        $dup1 = new stdClass();
                        $dup1->nDup = '001';
                        $dup1->dVenc = '2021-01-05';
                        $dup1->vDup = '930.00';
                        $nfe->tagdup($dup1);
                    
                        $dup2 = new stdClass();
                        $dup2->nDup = '002';
                        $dup2->dVenc = '2021-02-05';
                        $dup2->vDup = '942.12';
                        $nfe->tagdup($dup2);

                        $dup3 = new stdClass();
                        $dup3->nDup = '003';
                        $dup3->dVenc = '2021-03-05';
                        $dup3->vDup = '942.13';
                        $nfe->tagdup($dup3);
                        //dd($datas);
            */
        }
        //====================TAG PAGAMENTO===================
        if ($nfe1['natOp'] == 5124) {
            $pag = new stdClass();
            //$std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)

            $respPag = $nfe->tagpag($pag);

            //====================TAG DETALHE PAGAMENTO===================
            $detPag = new stdClass();
            $detPag->tPag = '15';
            $detPag->vPag = $nfe3['precoFinal'] + $nfe1['valorFrete']; //Obs: deve ser informado o valor pago pelo cliente
            //$detPag->CNPJ = '12345678901234';
            //$detPag->tBand = '01';
            //$detPag->cAut = '3333333';
            //$detPag->tpIntegra = 1; //incluso na NT 2015/002
            //$detPag->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

            $respDetPag = $nfe->tagdetPag($detPag);
        } else if ($nfe1['natOp'] == 5921) {
            $pag = new stdClass();
            //$std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)

            $respPag = $nfe->tagpag($pag);

            //====================TAG DETALHE PAGAMENTO===================
            $detPag = new stdClass();
            $detPag->tPag = '90';
            $detPag->vPag = 0.0; //Obs: deve ser informado o valor pago pelo cliente
            //$detPag->CNPJ = '12345678901234';
            //$detPag->tBand = '01';
            //$detPag->cAut = '3333333';
            //$detPag->tpIntegra = 1; //incluso na NT 2015/002
            //$detPag->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

            $respDetPag = $nfe->tagdetPag($detPag);
        } else {
            $pag = new stdClass();
            //$std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)

            $respPag = $nfe->tagpag($pag);

            //====================TAG DETALHE PAGAMENTO===================
            $detPag = new stdClass();
            $detPag->tPag = '99';
            $detPag->vPag = $nfe3['precoFinal'] + $nfe1['valorFrete']; //Obs: deve ser informado o valor pago pelo cliente
            //$detPag->CNPJ = '12345678901234';
            //$detPag->tBand = '01';
            //$detPag->cAut = '3333333';
            //$detPag->tpIntegra = 1; //incluso na NT 2015/002
            //$detPag->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

            $respDetPag = $nfe->tagdetPag($detPag);
        }
        //====================INFO ADICIONAL===================
        $stdInfo = new stdClass();
        $stdInfo->infAdFisco = $nfe3['infoAdc'] . " --- DOCUMENTO EMITIDO POR ME OU EPP OPTANTE PELO SIMPLES NACIONAL, CONFORME LEI COMPLEMENTAR 123/2006 II - NAO GERA DIREITO A CREDITO FISCAL DE IPI. III - PERMITE O APROVEITAMENTO DO CREDITO DE ICMS NO VALOR DE R$ " . $icms->vCredICMSSN . " CORRESPONDENTE A ALIQUOTA DE " . $aliquota->aliquota . ", NOS TERMOS DO ART. 23 DA LC 123/2006";
        //dd($nfe3['infoAdc']);
        //$std->infCpl = 'informacoes complementares';

        $nfe->taginfAdic($stdInfo);

        //====================MONTA A NOTA FISCAL ====================

        $erros = $nfe->getErrors();
        //dd($erros);

        //$chave = $nfe->getChave();
        $resp = array();

        //dd($nfe);
        // UTILIZAR OU A PRIMEIRA OU SEGUNDA OPCAO CASO ERRO XML NOT IS VALID
        try {
            $xml = $nfe->monta();
            //$xml = $nfe->getXML();
            //dd($xml);
        } catch (\Throwable $th) {
            dd($th);
        }



        file_put_contents('xmlTemp.xml', $xml);
        //dd($xml);
        $firma = Auth::user()->firma;
        Storage::put('Nfe/UltimoXML/' . $firma . '/' . 'last.txt', $xml);
        Storage::put('Nfe/UltimoXML/' . $firma . '/' . 'last.xml', $xml);

        //dd($xml);


        //=== CODIGO PARA GERAR O CÓDIGO DA NFE
        $mes = date('m');
        $ano = date('y');
        //$chave = $ide->cUF.$ano.$mes.$emit->CNPJ.$ide->mod.'00'.$ide->serie.$cNFcomZero.$ide->tpEmis.$ide->cNF.'0';
        $chave = Keys::build($ide->cUF, $ano, $mes, $emit->CNPJ, $ide->mod, $ide->serie, $ide->nNF, $ide->tpEmis, $ide->cNF);
        //=== COLOCA O XML E A CHAVE NO ARRAY DE RETORNO
        array_push($resp, $xml);
        array_push($resp, $chave);
        array_push($resp, $ide->nNF);
        array_push($resp, $cfopRetorno);
        // DECOMENTAR PARA VER SE A CHAVE É IGUAL A NOTA 
        //dd($chave,$nfe->getChave());

        return $resp;
    }

    public function assinar($xml)
    {
        try {
            $xmlSigned = $this->tools->signNFe($xml);
        } catch (\Exception $e) {
            dd('Erro: ', $e);
        }
        return $xmlSigned;
    }

    public function transmitir($xmlSigned, $chave)
    {

        try {

            //Envia o lote
            $resp = $this->tools->sefazEnviaLote([$xmlSigned], 1);
            

            $st = new Standardize();
            $std = $st->toStd($resp);
            if ($std->cStat != 103) {
                //erro registrar e voltar
                exit("[$std->cStat] $std->xMotivo");
            }
            $recibo = $std->infRec->nRec; // Vamos usar a variável $recibo para consultar o status da nota

            sleep(4);

            $xmlFinal = $this->consultaRecibo($recibo,$xmlSigned,$chave);
            return $xmlFinal;
            
        } catch (\Exception $e) {
            echo "Erro Protocolo: " . $e->getMessage();
        }
    }

    public function consultaRecibo($recibo,$xmlSigned,$chave)
    {
        try {
            $protocolo = $this->tools->sefazConsultaRecibo($recibo);

            //transforma o xml de retorno em um stdClass
            $st = new Standardize();
            $std = $st->toStd($protocolo);

            if ($std->cStat == '103') { //lote enviado
                //Lote ainda não foi precessado pela SEFAZ;
            }
            if ($std->cStat == '105') { //lote em processamento
                //tente novamente mais tarde
                sleep(3);
                $this->consultaRecibo($recibo,$xmlSigned,$chave);
            }

            if ($std->cStat == '104') { //lote processado (tudo ok)

                if ($std->protNFe->infProt->cStat == '100') { //Autorizado o uso da NF-e
                    // $return = [
                    //     "situacao" => "autorizada",
                    //     "numeroProtocolo" => $std->protNFe->infProt->nProt,
                    //     "xmlProtocolo" => $xmlResp
                    // ];

                    //Protocola o recibo no XML
                    $request = $xmlSigned;
                    $response = $protocolo;

                    $xmlFinal = Complements::toAuthorize($request, $response);

                    //"{cnpj}/nfe/homologacao/2020-08/{chave}.xml";

                    file_put_contents('nfeTransmit.xml', $xmlFinal);

                    $mes = date('m');
                    $ano = date('Y');
                    $firma = Auth::user()->firma;
                    //header('Content-type: text/xml; charset=UTF-8');
                    //file_put_contents('storage/'.$mes.$ano.'/'.$chave.'.xml',$xmlFinal);
                    $path = 'NfeMF/' . $mes . '-' . $ano . '/' . $chave;
                    session(['path_nfe' => $path]);
                    Storage::put('Nfe' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.xml', $xmlFinal);

                    Storage::put('Nfe/UltimoXMLT/' . $firma . '/' . 'lastTransmit.xml', $xmlFinal);

                    return $return = [
                        "situacao" => "aprovada",
                        "xmlFinal" => $xmlFinal,
                    ];
                } elseif (in_array($std->protNFe->infProt->cStat, ["110", "301", "302"])) { //DENEGADAS
                    return $return = [
                        "situacao" => "denegada",
                        "numeroProtocolo" => $std->protNFe->infProt->nProt,
                        "motivo" => $std->protNFe->infProt->xMotivo,
                        "cstat" => $std->protNFe->infProt->cStat,
                        // "xmlProtocolo" => $xmlResp
                    ];
                } else { //não autorizada (rejeição)
                    return $return = [
                        "situacao" => "rejeitada",
                        "motivo" => $std->protNFe->infProt->xMotivo,
                        "cstat" => $std->protNFe->infProt->cStat
                    ];
                }
            } else { //outros erros possíveis
                return $return = [
                    "situacao" => "rejeitada",
                    "motivo" => $std->xMotivo,
                    "cstat" => $std->cStat
                ];
            }
        } catch (\Exception $e) {
            echo str_replace("\n", "<br/>", $e->getMessage());
        }
    }

    //GERAR A DANFE
    public function gerarDanfe($chave)
    {
        $firma = Auth::user()->firma;
        $mes = date('m');
        $ano = date('Y');
        $xml = Storage::get('Nfe' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.xml');

        $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents("logoMF.jpg"));

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
            Storage::put('Nfe' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.pdf', $pdf);


            //DESCOMENTAR AS DUAS LINHAS ABAIXO PARA MOSTRAR A DANFE
            //header('Content-Type: application/pdf');
            //echo $pdf;
        } catch (Exception $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }

    public function gerarDanfeAvulsa()
    {
        $firma = Auth::user()->firma;
        $mes = date('m');
        $ano = date('Y');
        $xml = Storage::get('Nfe/UltimoXMLT/' . $firma . '/' . 'lastTransmit.xml',);

        $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents("logoMF.jpg"));

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
            header('Content-Type: application/pdf');
            echo $pdf;
            //Storage::put('Nfe'.$firma.'/'.$mes.'-'.$ano.'/'.$chave.'.pdf', $pdf);


            //DESCOMENTAR AS DUAS LINHAS ABAIXO PARA MOSTRAR A DANFE
            //header('Content-Type: application/pdf');
            //echo $pdf;
        } catch (Exception $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }

    //GERAR A CARTA DE CORRECAO
    public function gerarCartaCorrecaoPdf($chave)
    {
        $firma = Auth::user()->firma;
        $mes = date('m');
        $ano = date('Y');
        $xml = Storage::get('NfeCartaCorrecao' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.xml');
        $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents("logoMF.jpg"));



        $dadosEmitente = [
            'razao' => 'METALFLEX INDUSTRIA E COMERCIO DE MOLAS LTDA ME',
            'logradouro' => 'RUA PRINCESA ISABEL',
            'numero' => '70',
            'complemento' => 'FIRMA',
            'bairro' => 'JARDIM PACAEMBU',
            'CEP' => '13424586',
            'municipio' => 'Piracicaba',
            'UF' => 'SP',
            'telefone' => '1934330215',
            'email' => 'atendimento@metalflex.ind.br'
        ];

        try {
            $daevento = new Daevento($xml, $dadosEmitente);
            $daevento->debugMode(false);
            $daevento->creditsIntegratorFooter('FlexCode - By Matheus Filho');
            $pdf = $daevento->render($logo);
            Storage::put('NfeCartaCorrecao' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.pdf', $pdf);
            //header('Content-Type: application/pdf');
            //echo $pdf;
        } catch (\Exception $e) {
            dd('Erro', $e->getMessage());
        }
    }

    //FUNCOES EXTRAS

    public function inutilizaNfe($config)
    {

        try {
            $certificadoDigital = file_get_contents('..\app\Services\certMF.pfx');
            $certificate = Certificate::readPfx($certificadoDigital, '01111972');
            $tools = new Tools(json_encode($config), $certificate);

            $nSerie = '1';
            $nIni = '9764';
            $nFin = '9904';
            $xJust = 'Erro de digitação dos números sequenciais das notas';
            $response = $tools->sefazInutiliza($nSerie, $nIni, $nFin, $xJust);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            echo $json;
            $std1 = new Standardize($response);
            $retorno = $std1->toStd();
            $cStat = $retorno->infInut->cStat;
            if ($cStat == '102' || $cStat == '563') { //validou
                file_put_contents('inutizar.xml', $response); //grava o xml da inutilzação
            } else {
                dd('houve alguma falha no evento');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function corrigirNfe($config, $chaveNf, $just, $nEvento)
    {
        try {

            $certificadoDigital = file_get_contents('..\app\Services\certMF.pfx');
            $certificate = Certificate::readPfx($certificadoDigital, '01111972');
            $tools = new Tools(json_encode($config), $certificate);
            $tools->model('55');

            $chave = $chaveNf; //Chave da Nfe 
            $xCorrecao = $just; //Justificativa da correção
            $nSeqEvento = $nEvento + 1; //Numero do evento, ou seja qual o n° de cartas já feito
            $response = $tools->sefazCCe($chave, $xCorrecao, $nSeqEvento);
            $mes = date('m');
            $ano = date('Y');

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            $firma = Auth::user()->firma;
            //verifique se o evento foi processado
            if ($std->cStat != 128) {
                dd('Erro Ao Tirar Carta de Correção!  Erro numero:', $std->cStat);
            } else {
                $cStat = $std->retEvento->infEvento->cStat;
                if ($cStat == '135' || $cStat == '136') {
                    //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
                    $xml = Complements::toAuthorize($tools->lastRequest, $response);
                    file_put_contents('correcaoMF.xml', $xml);
                    Storage::put('NfeCartaCorrecao' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.xml', $xml);
                    return 1;
                } else {
                    dd('Erro Ao Tirar Carta de Correção!  Erro numero:', $std->cStat);
                }
            }
        } catch (\Exception $e) {
            dd('Erro!', $e, $e->getMessage());
        }
    }

    public function cancelarNfe($config, $chave, $just, $protocolo)
    {
        try {

            $certificadoDigital = file_get_contents('..\app\Services\certMF.pfx');
            $certificate = Certificate::readPfx($certificadoDigital, '01111972');
            $tools = new Tools(json_encode($config), $certificate);
            $tools->model('55');

            $chave = $chave;
            $xJust = $just;
            $nProt = $protocolo;
            $mes = date('m');
            $ano = date('Y');

            $response = $tools->sefazCancela($chave, $xJust, $nProt);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            $firma = Auth::user()->firma;

            //verifique se o evento foi processado
            if ($std->cStat != 128) {
                //houve alguma falha e o evento não foi processado
                dd('Erro Ao Cancelar Nota MF!  Erro numero:', $std->cStat);
            } else {
                $cStat = $std->retEvento->infEvento->cStat;
                if ($cStat == '101' || $cStat == '135' || $cStat == '155') {
                    //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
                    $xml = Complements::toAuthorize($tools->lastRequest, $response);
                    file_put_contents('cancelarMF.xml', $xml);
                    Storage::put('NfeCancelada' . $firma . '/' . $mes . '-' . $ano . '/' . $chave . '.xml', $xml);
                    return 1;
                } else {
                    //houve alguma falha no evento 
                    dd('Erro Ao Cancelar Nota!  Erro numero:', $std->cStat);
                }
            }
        } catch (\Exception $e) {
            dd('Erro!', $e, $e->getMessage());
        }
    }

    function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
}
