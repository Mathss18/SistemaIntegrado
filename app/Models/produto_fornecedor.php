<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produto_fornecedor extends Model
{
    protected $table = "produto_fornecedor";

    protected $primaryKey = 'ID_produto_fornecedor';

    protected $fillable = [
        'last_preco','cod_fabricacao','descricao','grupo','ID_fornecedor','unidade_saida','preco_venda','obs','path_imagem','firma'
    ];

    public $timestamps = false;

    
}
