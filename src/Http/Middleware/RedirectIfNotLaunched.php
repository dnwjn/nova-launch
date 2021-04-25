<?php

namespace Dnwjn\NovaLaunch\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotLaunched
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            config('nova-launch.enabled', false)
            && ! has_launched()
            && ! can_bypass()
            && $request->routeIs(config('nova-launch.routes.included', ['*']))
            && ! $request->routeIs(array_merge(config('nova-launch.routes.excluded', []), ['*nova-launch*']))
        ) {
            return redirect()->route('nova-launch.visitors.index');
        }

        return $next($request);
    }
}
