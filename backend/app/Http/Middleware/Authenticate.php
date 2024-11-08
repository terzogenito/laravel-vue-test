<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    
    use ResponseTrait;

    
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    
    protected function unauthenticated($request, array $guards)
    {
        throw new HttpResponseException(
            $this->responseError(null,  'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED)
        );
    }
}
