<?php declare(strict_types=1);

namespace App\Shared\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use function url;

final class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return url('/login');
        }
    }
}