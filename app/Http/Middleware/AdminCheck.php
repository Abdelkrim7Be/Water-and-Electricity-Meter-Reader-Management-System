<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // \Log::info('inside middleware!');
        if ($request->path() == 'app/admin_login') {
            return $next($request);
        }
        if (!Auth::check()) {
            // return redirect('/login');
            return response()->json([
                'msg' => 'Vous n\'avez pas le droit d\'accéder à ce route!...',
                'url' => $request->path(),
            ], 402);
        }
        $user = Auth::user();
        if($user->role->userType == "User"){
            return response()->json([
                'msg' => 'Vous n\'avez pas le droit d\'accéder à ce route!...',
            ], 402);
        }
        return $next($request);
    }
} 