<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["login", "register"]]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!($token = auth()->attempt(request(["email", "password"])))) {
            return $this->errorResponse("Error de usuario y contraseña", 401);
        }

        return $this->respondWithToken($token);
    }

    public function user()
    {
        $user = auth()->user();
        return $this->successResponse($user, 200);
    }

    public function logout()
    {
        auth()->logout();
        return $this->showMessage("Sesión Finalizada");
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' =>'required',
            'lastname' => 'required',
            'role_id' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = auth()->attempt([
            "email" => $request->email,
            "password" => $request->password,
        ]);

        return $this->successResponse(
            [
                "message" => "Usuario Registrado exitosamente",
                $token
            ],
            201
        );
    }

    protected function respondWithToken($token)
    {
        $user = auth()->user();
            return response()->json([
                "token" => $token,
                "type" => "bearer",
                "expires_in" =>
                    auth()
                        ->factory()
                        ->getTTL() * 60,
                "user" => $user->load('role:id,nombre'),
            ]);
    }

}
