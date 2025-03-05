<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->user()) {
            session()->flush();

            $allowedIntent = ['admin/*'];

            foreach ($allowedIntent as $intent) {
                if ($request->is($intent)) {
                    session()->put('url.intended', $request->url());
                    break;
                }
            }
            return redirect()->to(route('admin.login'))->with('error', 'Session Expired, You need to login again!');
        }
        return $next($request);
    }
}
