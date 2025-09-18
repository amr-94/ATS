<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('recruiter/*')) {
                return route('recruiter.login');
            }

            if ($request->is('candidate/*')) {
                return route('candidate.login');
            }

            // fallback
            return route('recruiter.login');
        }
    }
}