<?php
namespace App\Services\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $userData): array
    {
        $user = $this->authRepository->createUser([
            'name' => $userData['fullName'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        return $this->generateLoginResponse($user);
    }

    public function login(array $credentials): array
    {
        $user = $this->authRepository->getUserByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return ['error' => ['Invalid Credentials']];
        }

        return $this->generateLoginResponse($user);
    }

    public function logout($request): void
    {
        $this->authRepository->deleteUserTokens($request->user());
    }

    private function generateLoginResponse(User $user): array
    {
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user = UserResource::make($user);
        return [
            'user' => $user,
            'token' => [
                'accessToken' => $token,
                'token_type' => 'Bearer'
            ],
        ];
    }
}
