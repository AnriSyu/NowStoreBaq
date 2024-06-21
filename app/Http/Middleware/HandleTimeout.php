<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HandleTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (Exception $e) {
            if ($e instanceof HttpException && $e->getStatusCode() == 504) {
                // Log the error or handle it as needed
                Log::error('Execution time exceeded: ' . $e->getMessage());
                return response()->json(['error' => 'Execution time exceeded'], 504);
            }

            throw $e;
        }
    }
}
