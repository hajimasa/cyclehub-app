<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'ログインが必要です。');
        }

        if (!auth()->user()->is_admin) {
            return redirect('/dashboard')->with('error', '管理者権限が必要です。');
        }

        return $next($request);
    }
}