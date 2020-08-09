<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NfeService;
use Illuminate\Http\Request;
use stdClass;

class NfeController extends Controller
{

    public function index()
    {
        return view('admin.nfe.index');
    }

    public function create()
    {
        //
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
        dd($xmlEnviada);
        $danfe = $nfeService->gerarDanfe();
        dd('OLA');
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
