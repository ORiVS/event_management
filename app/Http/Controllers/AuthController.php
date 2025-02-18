<?php

namespace App\Http\Controllers;

use App\EventManagement\Users\UserService;
use App\EventManagement\Users\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\EventManagement\Users\Requests\RegisterRequest;
use App\EventManagement\Users\User;

class AuthController extends Controller
{

    public function __construct(protected  UserService $userService) {

    }

    public function register(RegisterRequest $request) : JsonResponse
    {
        $user = $this->userService->register($request->validated());

        $token = $user->createToken($request->input("name"));

    return response()->json([
        'user' => $user,
        'token' => $token->plainTextToken,
    ]);
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $data = $request->validated();

        try {
            $user = $this->userService->login($data); // Essaye de connecter l'utilisateur
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken($data['email']); // Crée un token avec l'email de l'utilisateur

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are Logged out'
        ];
    }
}
