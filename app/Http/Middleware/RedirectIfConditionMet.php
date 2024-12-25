<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
class RedirectIfConditionMet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(View::getShared('globalData')['globalData']->indefinitely == 0){
            $targetDate = Carbon::parse(View::getShared('globalData')['globalData']->active_at); // Дата, которую нужно проверить
            if ($targetDate->isPast()) {
                return redirect()->route('activated');
            }
        }
        

        return $next($request);
    }
}
