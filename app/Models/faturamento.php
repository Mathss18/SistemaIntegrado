<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class faturamento extends Model
{
    protected $table = "faturamento";

    protected $primaryKey = 'ID_faturamento';

    public $timestamps = false;

    protected $fillable = [
       'vale','nfe','situacao','cliente','peso','valor','firma','data','status'
    ];
}
