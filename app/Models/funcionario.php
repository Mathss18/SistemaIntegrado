<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = "funcionario";

    protected $primaryKey = 'ID_funcionario';

    public $timestamps = false;

    protected $fillable = ['nome','perfil','funcPedido','nivel','money'

    ];
}
