<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class qualidade extends Model
{
    protected $table = "qualidade";

    protected $primaryKey = 'ID_qualidade';

    public $timestamps = false;

    protected $fillable = [
        'of','codigo','cliente','abertura','arame','interno','externo','passo','lo_corpo','lo_total','espiras','data','qtde','sobra','acabamento','obs'
    ];
}
