<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedidoCompra extends Model
{
    protected $table = "pedidocompra";

    protected $primaryKey = 'ID_pedidoCompra';

    public $timestamps = false;

    protected $fillable = ['cod_pedidoCompra','ID_fornecedor','ID_produto_ID_fornecedor',
    'qtde_prod','obs','prazo_entrega','cond_pagto','data','path_pedidoCompra','status'];
}
