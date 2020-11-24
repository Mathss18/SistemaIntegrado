<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class evento extends Model
{
    protected $table = "evento";

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id','start','end','title','color','description','firma','ID_cliente','favorecido','ID_fornecedor','tipoFav','ID_banco','ID_funcionario','ID_transportadora','valor','numero','situacao'
    ];
}
