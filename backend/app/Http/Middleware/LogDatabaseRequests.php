<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Trail;
use Illuminate\Support\Facades\Auth;

class LogDatabaseRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Skip logging for trail POST requests
        if ($request->is('api/trails') && $request->isMethod('post')) {
            return $response;
        }

        // Log to the trails table
        if (Auth::check()) {
            Trail::create([
                'user_id' => Auth::id(),
                'menu_id' => null, // Adjust if menu_id is applicable
                'method' => $request->method(),
                'datetime' => now(),
            ]);
        }

        return $response;
    }
}
