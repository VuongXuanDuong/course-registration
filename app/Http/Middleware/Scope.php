<?php


namespace App\Http\Middleware;

use Closure;

class Scope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $scope)
    {
        if (!$request->user()->tokenCan($scope)) {
            return response()->json(['error' => 'unauthorized', 'scope' => $scope], 403);
        }

        return $next($request);
    }
}
