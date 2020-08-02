<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Funcionario;

class pedido extends Model
{
    protected $table = "pedido";

    protected $primaryKey = 'ID_pedido';

    public $timestamps = false;

    protected $fillable = ['OF','codigo','data_pedido','data_entrega','data_controle','quantidade','tipo','status','ID_cliente','path_desenho','firma'
        
    ];

}
