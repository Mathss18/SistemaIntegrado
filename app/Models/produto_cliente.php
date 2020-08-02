<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produto_cliente extends Model
{
    protected $table = "produto_cliente";

    protected $primaryKey = 'ID_produto_cliente';

    protected $fillable = [
        'last_preco','cod_fabricacao','descricao','grupo','ID_cliente','ncm','unidade_saida','imposto','preco_venda','cfop','obs','path_imagem','firma'
    ];

    public $timestamps = false;

    
}
