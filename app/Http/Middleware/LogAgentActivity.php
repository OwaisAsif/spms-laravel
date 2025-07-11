<?php

namespace App\Http\Middleware;

use App\Models\AgentActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogAgentActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            AgentActivity::create([
                'user_id' => Auth::id(),  // Ensure user_id is never null
                'url' => $request->fullUrl(), // Log the accessed URL
            ]);
        }

        return $next($request);
    }
}
