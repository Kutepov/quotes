<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $resourceName
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $resourceName)
    {
        /**
         * @var Model
         */
        $resource = $request->route()->parameter($resourceName);
        $user_id = \DB::table($resource->getTable())->find($resource->id)->user_id;
        if ($request->user()->id != $user_id) {
            abort(403, 'Недоступное действие.');
        }

        return $next($request);
    }
}
