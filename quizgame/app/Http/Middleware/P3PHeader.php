<?php namespace App\Http\Middleware;

use Closure;

class P3PHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS"');
        return $response;
    }
}