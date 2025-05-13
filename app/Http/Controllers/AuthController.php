<?php

namespace App\Http\Controllers;

use App\EventManagement\Users\UserService;
use App\EventManagement\Users\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\EventManagement\Users\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function __construct(protected  UserService $userService) {

    }

    public function register(RegisterRequest $request) : JsonResponse
    {
        $user = $this->userService->register($request->validated());

        $user->assignRole('participant');

        $user->sendEmailVerificationNotification();

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
            $user = $this->userService->login($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken($data['email']);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);

    }

    public function logout(Request $request): array
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are Logged out'
        ];
    }
}
