<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;

class Cors 
{
    public function handle($request, Closure $next)
    {
      $response = $next($request);
       $response->headers->set('Access-Control-Allow-Origin' , '*');
       $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
       $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

    return $response;
    }

   
    // protected $except = [
    //     'https://autooutletllc.com/miniapp/public/vendors/trq_order'
    // ];
}
