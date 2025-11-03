<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorCount;
use Illuminate\Support\Facades\Cache;

class TrackUniqueVisitor
{
    // How long to remember visitor IPs (in minutes)
    protected $cacheDuration = 60 * 24; // 24 hours

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // Cache key for this IP
        $cacheKey = 'visitor_ip_' . $ip;

        // Check if IP is already counted recently
        if (!Cache::has($cacheKey)) {
            // Increment visitor count
            $visitorCount = VisitorCount::firstOrNew([]);
            $visitorCount->count += 1;
            $visitorCount->save();

            // Store IP in cache to prevent recount for 24 hours
            Cache::put($cacheKey, true, $this->cacheDuration);
        }

        return $next($request);
    }
}
