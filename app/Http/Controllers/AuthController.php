<?php

namespace App\Http\Controllers;

use App\EventManagement\Users\UserService;
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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return  [
                'message' => 'The provided credentials are incorrect'
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are Logged out'
        ];
    }
}
