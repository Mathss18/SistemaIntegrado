<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class funcionario_pedido extends Model
{
    protected $table = "funcionario_pedido";

    protected $primaryKey = 'ID_funcionario_pedido';

    public $timestamps = false;

    protected $fillable = [
        'nota','ID_fornecedor','ID_funcionario','ID_pedido','ID_cliente','status','data_controle','data_baixa'
    ];
}
