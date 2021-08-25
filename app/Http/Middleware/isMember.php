<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isMember
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
        $user = $request->user();
        if ($user) {
            if ($user->role == 'Member') {
                return $next($request);
            }
        }
        return redirect()->route('index');
    }
}
