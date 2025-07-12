<?php

use App\Http\Controllers\api\auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\auth\RegisterController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\VendorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/auth/user/register", [RegisterController::class, "store"]);
Route::post("/auth/login", [LoginController::class, "authenticated"]);
Route::post("/register/vendor",[VendorController::class, "store"])->middleware("auth:sanctum");

Route::get("/products/{id}", [ProductController::class, "index"])->middleware("auth:sanctum");
Route::apiResource("products", ProductController::class)->middleware("auth:sanctum");
