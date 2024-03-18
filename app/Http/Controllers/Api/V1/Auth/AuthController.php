<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $registerUserData = $request->validated();
        $response = $this->authService->register($registerUserData);

        return response()->json($response);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $response = $this->authService->login($credentials);

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser(Request $request)
    {
        return UserResource::make($request->user());
    }
}
