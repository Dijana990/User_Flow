<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pretpostavljam da u korisničkom modelu postoji polje 'role'
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized - Admins only'], 403);
        }

        return $next($request);
    }
}
