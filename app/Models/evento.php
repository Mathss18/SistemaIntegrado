<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class evento extends Model
{
    protected $table = "evento";

    protected $primaryKey = 'ID_evento';

    public $timestamps = false;

    protected $fillable = [
        'ID_evento','id','start','end','title','color','description','firma'
    ];
}
