<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->has(["email", "password"])) {
            return response()->json(["error" => "Bad parameter"], 401);
        }

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(["error" => "Bad parameter"]);
        }

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$token = auth("api")->attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json(["error" => "Unauthorized"], 401);
        }
        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credential = request(["email", "password"]);

        if (!$token = auth("api")->attempt($credential)) {
            return response()->json(["error" => "Unauthorized"], 401);
        }

        return $this->respondWithToken($token);
    }

    public function validation(Request $request)
    {
        return response()->json();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

}
