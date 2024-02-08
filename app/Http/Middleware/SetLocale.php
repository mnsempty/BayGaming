<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $defaultLanguage = config('app.locale');
        $language = session('language', Cookie::get('language', $defaultLanguage));
        App::setLocale($language);

        return $next($request);
    }
}
