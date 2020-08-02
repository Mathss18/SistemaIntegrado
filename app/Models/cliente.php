<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table = "cliente";

    protected $primaryKey = 'ID_cliente';

    public $timestamps = false;

    protected $fillable = [
        'nome','cpf_cnpj','email','telefone','telefone2','inscricao_estadual','logradouro','numero','cidade','uf','bairro','contato','cep','tipo'
    ];
}
