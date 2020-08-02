<?php

namespace App\Models;
use App\Models\Estoque;

use Illuminate\Database\Eloquent\Model;

class produto extends Model
{
    protected $table = "produto";

    protected $primaryKey = 'ID_produto';

    protected $fillable = [
        'nome','utilizacao','estoque_minimo'
    ];

    public $timestamps = false;

    
}
