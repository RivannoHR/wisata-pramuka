<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteStatistic;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track visits for GET requests and exclude admin/API routes
        if ($request->isMethod('GET') && 
            !$request->is('admin/*') && 
            !$request->is('api/*') &&
            !$request->is('storage/*') &&
            !$request->ajax()) {
            
            // Check if this is a unique visit (using session to avoid multiple counts per session)
            if (!session()->has('visit_tracked')) {
                SiteStatistic::incrementVisits();
                session(['visit_tracked' => true]);
            }
        }

        return $next($request);
    }
}
