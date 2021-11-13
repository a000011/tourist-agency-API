<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorUnauthorizedResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User as UserModel;

class User extends Controller
{
    public function login(Request $request)
    {
        if ($user = UserModel::where('login', $request->login)->first()) {
            if(Hash::check($request->password, $user->password)){
                $token = Str::random(60);
                if (!UserModel::where('remember_token', $token)->first()) {
                    $user->remember_token = $token;
                    $user->save();
                    return $token;
                }
            }
        }

        return response()->json(
            new ErrorUnauthorizedResource(null),
            401
        );
    }

    public function me(Request $request)
    {
        return response()->json(new UserResource($request->user()));
    }
}

