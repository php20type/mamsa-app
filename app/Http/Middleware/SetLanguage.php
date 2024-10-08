<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(isset(auth()->user()->id)){
            $lang=auth()->user()->lang;
        }
        else{
            $lang=session()->get('locale');
        }
        if($lang!='' && $lang!='undefined'){
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
