<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MultipleDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->getHost();

        switch ($domain) {
            case 'domain1.com':
                // Setzen Sie Variablen oder führen Sie Aktionen für domain1.com aus
                break;
            case 'domain2.com':
                // Setzen Sie Variablen oder führen Sie Aktionen für domain2.com aus
                break;
            // ...
        }
        return $next($request);
    }
}
