<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $key = 132144;
            $result = Http::withHeaders([
                "Content-Type" => "application/json",
            ])->post('https://lidasite.ru/api/activeKey', ['key'=>$key]);
            $apiData = $result->json();
            dd($apiData);
            
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            dd($e);
        }
        

        return $next($request);
    }
}
