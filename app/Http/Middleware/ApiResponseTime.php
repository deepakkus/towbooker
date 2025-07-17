<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiResponseTime
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2); // in milliseconds

        // Option 1: Add to response headers
        $response->headers->set('X-Response-Time', "{$duration}ms");

        // Option 2: (Optional) Add to response body (JSON only)
        if ($response->headers->get('Content-Type') === 'application/json') {
            $data = json_decode($response->getContent(), true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                $data['response_time_ms'] = $duration;
                $response->setContent(json_encode($data));
            }
        }

        return $response;
    }
}

?>