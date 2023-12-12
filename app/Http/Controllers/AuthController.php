<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'          =>      'required|min:3|max:100|string',
            'email'         =>      'required|email|unique:users,email',
            'password'      =>      'required|string|min:8|max:32',
            'c_password'    =>      'required|string|same:password'
        ]);


        if($validator->fails())
        {
            return $this->errorResponce(422, $validator->messages());
        }

        $user = User::query()->create([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'password'  =>  Hash::make($request->password),
        ]);

        $token = $user->createToken('myApp')->plainTextToken;

        return $this->successResponce(201, [

            'user'  =>  (new UserResource($user)),
            'token' =>  $token

        ], 'create user successfully.');

    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'         =>      'required|email|unique:users,email',
            'password'      =>      'required|string|min:8|max:32',
        ]);


        if($validator->fails())
        {
            return $this->errorResponce(422, $validator->messages());
        }

        $user = User::query()->where('email', $request->email)->first();

        if(!$user)
        {
            return $this->errorResponce(401, 'User not found !');
        }

        if(!Hash::check($request->password, $user->password))
        {
            return $this->errorResponce(401, 'password is incorrect');
        }

        $token = $user->createToken('myApp')->plainTextToken;

        return $this->successResponce(200, [

            'user'  =>  (new UserResource($user)),
            'token' =>  $token

        ], 'create user successfully.');

    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponce(200, [], 'logout successfully .');

    }
}
