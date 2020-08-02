<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relogio extends Model
{
    protected $table = "relogio";

    protected $primaryKey = 'ID_relogio';

    public $timestamps = false;

    protected $fillable = [
        'inicio','fim','data','status',
    ];
}
