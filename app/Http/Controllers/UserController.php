<?php

namespace App\Http\Controllers;

use App\Entities\LoginCredentialsEntity;
use App\Entities\RegistrationCredentialsEntity;
use App\Helpers\SerializeHelper;
use App\Http\Resources\ErrorUnauthorizedResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User as UserModel;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $dtoRequest = (new SerializeHelper())->getObjectFromJson(
            json_encode($request->toArray()),
            LoginCredentialsEntity::class
        );

        $validator = Validator::make($request->all(), [
            'login' => 'required|min:3',
            'password' => 'required|min:3',
        ]);

        if (!$validator->fails()) {
            if ($user = UserModel::where('login', $dtoRequest->getLogin())->first()) {
                if (Hash::check($dtoRequest->getPassword(), $user->password)) {
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
        return response()->json(
            [
                'code' => 400,
                'errors' => array_map(
                    function ($errors) {
                        foreach ($errors as $key => $value) {
                            return $value;
                        }
                    },
                    $validator->errors()->toArray()
                )
            ],
            400
        );
    }

    public function registration(Request $request)
    {
        $dtoRequest = (new SerializeHelper())->getObjectFromJson(
            $request->getContent(),
            RegistrationCredentialsEntity::class
        );

        $validator = Validator::make($request->all(), [
            'login' => 'required|min:3',
            'password' => 'required|min:3',
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
        ]);

        if (!$validator->fails()) {
            if (UserModel::where('login', $dtoRequest->getLogin())->first() !== null) {
                return response()->json(['code' => 400, 'errors' => ['login' => 'login is already taken']], 400);
            }
            $newUser = new UserModel();
            $newUser->role = 'user';
            $newUser->login = $dtoRequest->getLogin();
            $newUser->password = Hash::make($dtoRequest->getPassword());
            $newUser->firstname = $dtoRequest->getFirstname();
            $newUser->lastname = $dtoRequest->getLastname();
            $newUser->save();

            return response()->json(['status' => 'success'], 201);
        }
        return response()->json(
            [
                'code' => 400,
                'errors' => array_map(
                    function ($errors) {
                        foreach ($errors as $key => $value) {
                            return $value;
                        }
                    },
                    $validator->errors()->toArray()
                )
            ],
            400
        );

    }

    public function me(Request $request)
    {
        $userInfo = (new UserResource($request->user()))->getArray();
        $userComments = Comment::where('user_id', $request->user()['id'])->get();
        $userInfo['comments'] = [];
        foreach ($userComments as $comment) {
            $userInfo['comments'][] = [
                'tourId' => $comment['tour_id'],
                'content' => $comment['content'],
                'mark' => $comment['mark']

            ];
        }

        return response()->json($userInfo);
    }
}

