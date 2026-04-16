<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Show maintenance page to all frontend visitors when maintenance mode is enabled.
     * Admin routes are always exempt.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Setting::get('maintenance_mode') === '1'
            && ! $request->is('admin*')
        ) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
