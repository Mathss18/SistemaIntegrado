<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nfe extends Model
{
    protected $table = "nfe";

    protected $primaryKey = 'ID_nfe';

    public $timestamps = false;

    protected $fillable = [
        'OF','tpNF','finNFe','natOp','nomeCli','cpf_cnpjCli','contatoCli','formaPag','numParc',
        'modFrete','valorFrete','meioPagto','tipo','cpf_cnpjTransp','contatoTransp',
        'descricaoProd','precoProd','especie','qtdeComp','desconto','tipoDesc','pesoBruto','pesoLiq','unidade',
        'infoAdc','precoFinal','qtdProd','codFabriProd','ncm','total','codFabriProd','descricaoProd','quantidade',
        'precoProd','totalQtde','ieCli','emailCli','ID_cliente','ID_transp','ufCli','nomeTransp','chaveNF','nNF',
        'data_abertura','porcento','path_nfe','nSeqEvento','meioPgto','numParcelas','formaPgto','firma','cfop','unidade_saida'
    ];
}
