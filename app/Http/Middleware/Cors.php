<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class Cors {
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        return $response
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
    }
}
