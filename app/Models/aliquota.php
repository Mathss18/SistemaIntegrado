<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class aliquota extends Model
{
    protected $table = "aliquota";

    protected $primaryKey = 'ID_aliquota';

    public $timestamps = false;

    protected $fillable = [
        'ID_aliquota','aliquota'
    ];
}
