<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): JsonResponse|Response
    {
        try {
            $header = $request->header('Authorization');

            if (!$header || !preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
                return ApiResponse::response(['error' => 'Token não fornecido'], Response::HTTP_UNAUTHORIZED);
            }

            $token = $matches[1];
            $tokens = config('tokens');

            if (!isset($tokens[$token])) {
                return ApiResponse::response(['error' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
            }

            if (!in_array($permission, $tokens[$token])) {
                return ApiResponse::response(['error' => 'Permissão negada'], Response::HTTP_FORBIDDEN);
            }
        }
        catch (\InvalidArgumentException $e) {
            return ApiResponse::response([
                'error' => 'Formato do token é inválido'
            ], Response::HTTP_BAD_REQUEST);

        } catch (\Exception $e) {
            return ApiResponse::response([
                'error' => 'Unexpected exception',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Throwable $e) {
            return ApiResponse::response([
                'error' => 'Fatal error',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $next($request);
    }
}
