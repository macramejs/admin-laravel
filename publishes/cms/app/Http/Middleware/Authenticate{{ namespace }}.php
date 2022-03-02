<?php

namespace {{ namespace }}\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate{{ namespace }}
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string[]                 ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (! $user = Auth::user()) {
            return redirect(route('{{ name }}.login'));
        }

        if ($user->is_{{ name }}) {
            return $next($request);
        }

        abort(403);
    }
}
