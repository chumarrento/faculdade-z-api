<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Student;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['cpf', 'password']);

        $user = Student::where('cpf', $credentials['cpf'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('AccessToken')->accessToken;
            return $this->success([
                'user' => $user,
                'token' => $token
            ]);
        }

        return $this->unauthorized(['message' => 'Login/Senha inválido']);
    }
}
