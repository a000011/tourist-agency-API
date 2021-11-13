<?php

namespace App\Http\Middleware;

use App\Http\Resources\ErrorUnauthorizedResource;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = User::where('remember_token', $request->bearerToken())->first();
        if ($user !== null) {
            $request->setUserResolver(function () use ($user) { return $user; });
            return $next($request);
        }

        return new ErrorUnauthorizedResource(null);
    }
}
