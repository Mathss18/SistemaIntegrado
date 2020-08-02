<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rastreabilidade extends Model
{
    protected $table = "rastreabilidade";

    protected $primaryKey = 'ID_rastreabilidade';

    protected $fillable = [
        'lacre','cor','codigo','data','nota','cliente','quantidade','qtde'
    ];

    public $timestamps = false;
}
