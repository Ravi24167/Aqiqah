<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureApprovedAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isDkmAdmin() && !$user->is_approved) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun DKM Anda sedang menunggu persetujuan dari Super Admin. Harap hubungi Super Admin.');
        }

        return $next($request);
    }
}
