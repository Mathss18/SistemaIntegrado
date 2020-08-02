<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fornecedor extends Model
{
    protected $table = "fornecedor";

    protected $primaryKey = 'ID_fornecedor';

    public $timestamps = false;

    protected $fillable = [
        'firma','nome','cpf_cnpj','email','telefone','telefone2','inscricao_estadual','logradouro','numero','cidade','uf','bairro','contato','cep'
    ];
}
