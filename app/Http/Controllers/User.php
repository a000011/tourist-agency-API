<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorUnauthorizedResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
                    return response()->json([
                        'token' => $token
                    ]);
                }
            }
        }

        return response()->json(
            new ErrorUnauthorizedResource(null),
            401
        );
    }

    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        if (!$validator->fails()) {
            $newUser = new UserModel();
            $newUser->role = 'user';
            $newUser->login = $request->login;
            $newUser->password = Hash::make($request->password);
            $newUser->firstname = $request->firstname;
            $newUser->lastname = $request->lastname;
            $newUser->save();

            return response()->json(['status' => 'success'], 201);
        }

        return $validator->errors();
    }

    public function me(Request $request)
    {
        return response()->json(new UserResource($request->user()));
    }
}

