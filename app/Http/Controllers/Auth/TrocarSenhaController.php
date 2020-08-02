<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TrocarSenhaController extends Controller
{

    public function trocarSenha()
    {
        $usuario = Auth::user();
        $usuario = $usuario->toArray();
        
        
        //Digite a nova senha
        $novaSenha = 'niquel2020';
        $senhaCriptografada = bcrypt($novaSenha);

        $usuario['password'] = $senhaCriptografada;
        Auth::user()->update($usuario);
    }

}
