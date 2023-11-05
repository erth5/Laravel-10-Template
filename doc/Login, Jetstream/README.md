Route::get('/sip', function (Request $request) {
    info(env('DEVELOPER_EMAIL'));
    if (
        Auth::attempt([
            'email' => env('DEVELOPER_EMAIL'),
            'password' => env('DEVELOPER_PASSWORD')
        ])
    ) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});




<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AutoAuthDeveloper
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
                $developer = User::where('email', env('DEVELOPER_EMAIL'))->first();
                if ($developer) {
                    if (Hash::check(env('DEVELOPER_PASSWORD'), $developer->password)) {
                        auth()->login($developer);
                    }
                }
            }
        }
        return $next($request);
    }
}
