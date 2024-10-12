<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->is_admin) {
            return redirect("/Admin");
        }

        return $next($request);
    }
}
