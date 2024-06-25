<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('manager.login');
    }


    public function authenticate($request , array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        if (Auth::guard('manager')->check()) {
            return $this->auth->shouldUse('manager');
        }

        $this->unauthenticated($request, ['manager']);
    }
}
