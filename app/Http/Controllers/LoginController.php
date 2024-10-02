<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', ['error' => $validator->errors()]);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();

            // remove existing tokens
            $user->tokens()->delete();
            
            $expiresAt = now()->addHours(24);
            $success = [
                'token' => $user->createToken(config('app.name'), ['*'], $expiresAt)->plainTextToken,
                'token_expires_at' => $expiresAt,
            ];

            return $this->sendReponse($success, 'User logged in successfully.');
        }

        return $this->sendError('Invalid Credentials', ['error' => 'Unauthenticated']);
    }
}
