<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMasterAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== User::ROLE_MASTER_ADMIN) {
            abort(403, 'Halaman iki hanya tersedia untuk Master Admin.');
        }

        return $next($request);
    }
}
