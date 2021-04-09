<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

// Admin middleware
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !(Auth::user()->is_admin))
        {
            switch ($request->method())
            {
                case 'POST':
                    return response()->json([
                        'message' => 'Доступ запрещен!',
                    ], 403);

                    break;

                case 'GET':
                    abort(403, 'Доступ запрещен!');

                    break;

                default:
                    return response()->json([
                        'message' => 'Лол)',
                    ], 404);

                    break;
            }
            
        }

        return $next($request);
    }
}
