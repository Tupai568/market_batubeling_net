<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->is_admin) {
            return redirect("/Admin");
        }

        if ($request->user()->user_type == "reseller") {
            return $next($request);
        }

        if ($request->user()->user_type == "guest") {
            return redirect(route("favorite"));
        }

        return redirect("/");
    }
}
