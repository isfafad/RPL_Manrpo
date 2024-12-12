<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Rolemiddleware
{
    public function handle($request, Closure $next, $role)
    {
        Log::info('RoleMiddleware invoked', ['user' => Auth::user(), 'role' => $role]);
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        if ($user->role == $role) {
            return $next($request);
        }

        return redirect('/login');
    }
}
