<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {

        if (Auth::guest()){
            return ResponseFormatter::error('Unauthenticated');
        }

        if (empty($request->bearerToken())){
            return ResponseFormatter::error('Unauthenticated');
        }

        if (!Auth::check()){
            return ResponseFormatter::error('Unauthenticated');
        }

        return parent::handle($request, $next, $guards); // TODO: Change the autogenerated stub
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
