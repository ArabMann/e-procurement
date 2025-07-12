<?php

namespace App\Http\Controllers\api\auth;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;

class RegisterController extends Controller
{
    //
    public function store(StoreRegisterRequest $request)
    {
        $response = DB::transaction(function () use ($request) {
            $validation = $request->validated();

            $roleUser = Role::findOrFail(2);
            $validation["role_id"] = $roleUser->id;

            $storeRegister = User::create($validation);

            return (new UserResource($storeRegister))->additional([
                "success" => true,
                "message" => "Register Telah Berhasil",
            ]);
        });

        return $response;
    }
}
