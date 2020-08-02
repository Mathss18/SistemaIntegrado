<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class entrada_produto extends Model
{
    protected $table = "entrada_produto";

    protected $primaryKey = 'ID_entrada';

    protected $fillable = [
        'ID_produto','qtde','valor_unitario','data_entrada'
    ];

    public $timestamps = false;
}
