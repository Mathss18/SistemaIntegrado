<?php

namespace App\Models;
use App\Models\Produto;

use Illuminate\Database\Eloquent\Model;

class estoque extends Model
{
    protected $table = "estoque";

    protected $primaryKey = 'ID_estoque';

    protected $fillable = [
       
    ];

    public function produtos() {

        return $this->hasOne(Produto::class,'ID_produto', 'ID_produto');
      }
}
