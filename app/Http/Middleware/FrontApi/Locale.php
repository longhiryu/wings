<?php

namespace App\Http\Middleware\FrontApi;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Lấy locale từ header
        $locale = $request->header('locale');

        // Set locale cho hệ thống
        if (in_array($locale, config('languages'))) {
            App::setLocale($locale);
        }else{
            App::setLocale('vi');
        }

        return $next($request);
    }
}
