<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\laravel_messenger\HttpStatus;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $token = $user->createToken('access-token');

        return response()->json([
            "message" => "user created successfully",
            "token" => $token->plainTextToken,
        ], HttpStatus::OK);
    }
}
