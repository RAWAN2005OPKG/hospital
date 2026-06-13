<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $role = auth()->user()->role;
        $current = $role instanceof \BackedEnum ? $role->value : (string) $role;

        if (! in_array($current, $roles, true)) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
        }
        
        return $next($request);
    }
}