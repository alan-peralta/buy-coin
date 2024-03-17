<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|unique:users,email|email:rfc,spoof',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json($validateUser->errors(), 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'type' => 'Bearer Token',
                'token' => $user->createToken($user->name . "-API-TOKEN")->plainTextToken
            ], 200);

        } catch (Throwable $th) {
            return response()->json([
                'status' => [
                    'message' => $th->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email|email:spoof',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json($validateUser->errors(), 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'error' => [
                        'message' => 'Email & Password does not match with our record.'
                    ]
                ], 401);
            }

            $user = User::query()->where('email', $request->email)->first();

            return response()->json([
                'type' => 'Bearer Token',
                'token' => $user->createToken($user->name . "-API-TOKEN")->plainTextToken
            ], 200);

        } catch (Throwable $th) {
            return response()->json([
                'error' => [
                    'message' => $th->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json("", Response::HTTP_NO_CONTENT);
    }
}
