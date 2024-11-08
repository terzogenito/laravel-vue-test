<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Models\User;

class AuthController extends Controller
{
    
    use ResponseTrait;

    
    public $authRepository;
    
    public function __construct(AuthRepository $ar)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authRepository = $ar;
    }

    public function getUsers()
    {
        return response()->json(User::all());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            if ($token = $this->guard()->attempt($credentials)) {
                $data =  $this->respondWithToken($token);
            } else {
                return $this->responseError(null, 'Invalid Email and Password !', Response::HTTP_UNAUTHORIZED);
            }

            return $this->responseSuccess($data, 'Logged In Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $requestData = $request->only('username', 'email', 'password', 'password_confirmation', 'role');
            $user = $this->authRepository->register($requestData);
            if ($user) {
                if ($token = $this->guard()->attempt($requestData)) {
                    $data =  $this->respondWithToken($token);
                    return $this->responseSuccess($data, 'User Registered and Logged in Successfully', Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function logout(): JsonResponse
    {
        try {
            $this->guard()->logout();
            return $this->responseSuccess(null, 'Logged out successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    protected function respondWithToken($token): array
    {
        $data = [[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60 * 24 * 30, 
            'user' => $this->guard()->user()
        ]];
        return $data[0];
    }

    
    public function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard();
    }
}
