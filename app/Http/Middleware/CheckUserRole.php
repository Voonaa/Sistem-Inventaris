<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;
        
        // If no roles specified or user has one of the allowed roles
        if (empty($roles) || in_array($userRole, $roles)) {
            return $next($request);
        }

        // User doesn't have the required role
        return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
    }
}
