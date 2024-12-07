<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', 'vi'); // Nếu không có locale trong session thì mặc định là 'en'
        
        // Kiểm tra xem locale có hợp lệ không
        if (in_array($locale, ['en', 'vi'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}