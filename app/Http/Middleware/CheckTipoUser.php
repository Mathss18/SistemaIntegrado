<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckTipoUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$tipos)
    {   
        $funcao = Auth::user()->funcao;
        //dd($funcao);
        $autorizar = 0;
        
            foreach($tipos as $tipo) {
                if($funcao == $tipo){
                    $autorizar = 1;
                }     
            }
            if($autorizar == 1)
            return $next($request);
            else
            return redirect('home')->with('error','Você Não Tem Permissão Para Acessar Esta Área');
        
        
        
    }
}
