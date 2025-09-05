<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        try {
            $header = $request->header('Authorization');

            if (!$header || !preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
                return response()->json(['error' => 'Token não fornecido'], Response::HTTP_UNAUTHORIZED);
            }

            $token = $matches[1];
            $tokens = config('tokens');

            if (!isset($tokens[$token])) {
                return response()->json(['error' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
            }

            if (!in_array($permission, $tokens[$token])) {
                return response()->json(['error' => 'Permissão negada'], Response::HTTP_FORBIDDEN);
            }
        }
        catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => 'Invalid token format'
            ], Response::HTTP_BAD_REQUEST);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unexpected exception',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Fatal error',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $next($request);
    }
}
