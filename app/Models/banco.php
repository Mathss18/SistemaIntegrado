<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class banco extends Model
{
    protected $table = "banco";

    protected $primaryKey = 'ID_banco';

    public $timestamps = false;

    protected $fillable = [
        'ID_banco','saldo'
    ];
}
