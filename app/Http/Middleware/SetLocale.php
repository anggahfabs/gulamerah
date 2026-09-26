<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request and set the active application locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['id', 'en'];

        // Priority: 1. Session, 2. Cookie, 3. Config default ('id')
        $locale = session('locale', $request->cookie('gumer_locale', config('app.locale', 'id')));

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'id';
        }

        App::setLocale($locale);
        View::share('currentLocale', $locale);

        return $next($request);
    }
}
