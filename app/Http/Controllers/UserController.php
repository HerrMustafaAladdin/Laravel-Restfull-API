<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->paginate(1);
        return $this->successResponce(200,[
            'users' =>  UserResource::collection($users->load('posts')),
            'links' =>  PostResource::collection($users)->response()->getData()->links,
            'links' =>  PostResource::collection($users)->response()->getData()->meta
        ],'OK!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      =>  'required|min:3|max:130|string',
            'email'     =>  'required|email',
            'password'  =>  'required|min:8|max:120'
        ]);

        if($validator->fails())
        {
            return $this->errorResponce(422,$validator->messages());
        }

        $user = User::create([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'password'  =>  Hash::make($request->input('password'))
        ]);

        return $this->successResponce(200,$user, 'Create new user successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->successResponce(200, $user, 'Get User Successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'name'      =>  'required|min:3|max:130|string',
            'email'     =>  'required|email',
            'password'  =>  'required|min:8|max:120'
        ]);

        if($validator->fails())
        {
            return $this->errorResponce(422, $validator->messages());
        }

        $user->update([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'password'  =>  Hash::make($request->input('password'))
        ]);

        return $this->successResponce(200,$user, 'Update user successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponce(200, $user, 'Delete User Successfully.');
    }
}
