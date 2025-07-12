<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function authenticated(LoginRequest $request)
    {
        $validation = $request->validated();
        if (Auth::attempt($validation)) {
            $user = Auth::user();
            $token = $user->createToken("myToken")->plainTextToken;

            return (new UserResource($user))->additional([
                "success" => true,
                "message" => "Login Berhasil",
                "token" => $token,
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Tidak Berhasil Login"
        ]);
    }
}
