<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orcamento extends Model
{
    protected $table = "orcamento";

    protected $primaryKey = 'ID_orcamento';

    public $timestamps = false;

    protected $fillable = ['cod_orcamento','ID_cliente','ID_produto_cliente ',
    'qtde_prod','obs','prazo_entrega','cond_pagto','data','path_orcamento','pedidoCli'];
}
