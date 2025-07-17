<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectPartnerId
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->partner_id) {
            $request->attributes->set('partner_id', $request->user()->partner_id);
        }

        return $next($request);
    }
}
