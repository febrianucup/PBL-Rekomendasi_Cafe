<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roleName = strtolower(auth()->user()->role?->name ?? '');
        if (auth()->check() && $roleName === 'owner') {
            return $next($request);
        }
        return redirect()->route('permissionErr');
    }
}
