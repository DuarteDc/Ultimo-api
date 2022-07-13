<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductsController;
use Illuminate\Support\Collection;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    [
        "prefix" => "auth",
    ],
    function () {
        Route::post("login", [AuthController::class, "login"])->name("login");
        Route::post("logout", [AuthController::class, "logout"])->name(
            "logout"
        );
        Route::post("refresh", [AuthController::class, "refresh"])->name(
            "refresh"
        );
        Route::post("register", [AuthController::class, "register"])->name(
            "register"
        );
        Route::get("user", [AuthController::class, "user"])->name("user");
    }
);

Route::group(
    [
        "middleware" => "api",
    ],
    function () {
        Route::apiResource("products", ProductsController::class);
    }
);
