<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AutoAuthSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!app()->environment('production')) {
            if ($request->ip() === '127.0.0.1' || $request->ip() === '::1') {
                $superAdmin = User::where('email', env('SUPER_ADMIN_EMAIL'))->first();
                if (Hash::check(env('SUPER_ADMIN_PASSWORD'), $superAdmin->password)) {
                    auth()->login($superAdmin);
                }
            }
        }
        return $next($request);
    }
}
