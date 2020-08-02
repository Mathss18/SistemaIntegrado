<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class saida_produto extends Model
{
    protected $table = "saida_produto";

    protected $primaryKey = 'ID_saida';

    protected $fillable = [
        'ID_produto','qtde','valor_unitario','data_saida','banho'
    ];

    public $timestamps = false;
}

