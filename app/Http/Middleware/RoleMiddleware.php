<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user() || !$request->user()->hasRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Forbidden. You do not have permission to access this resource.',
                ], 403);
            }

            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}