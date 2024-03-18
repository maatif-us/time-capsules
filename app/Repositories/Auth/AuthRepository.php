<?php
namespace App\Repositories\Auth;



use App\Models\User;

class AuthRepository
{
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createUser(array $userData): User
    {
        return User::create($userData);
    }

    public function deleteUserTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
