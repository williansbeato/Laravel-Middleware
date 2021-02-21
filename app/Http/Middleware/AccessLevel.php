<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AccessLevel{
    
    public function handle(Request $request, Closure $next) {

        $nivel = 0;
     
        $rota = $request->route()->getName();

        if($rota != "negado") {

            if($rota != "menu"){

                if ($nivel == 0) {

                    return redirect('negado');

                }
                else if($nivel == 1 && $rota != "curso.index" && $rota != "disciplina.index"){
                    
                    return redirect('negado');
                
                }
            }
        }

        return $next($request);
    }
}
