<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
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
        $users = User::query()->orderBy('id','DESC')->paginate(10);
        return $this->successResponce(200, UserResource::collection($users), 'Show all users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'                  =>  'required|min:3|max:100|string',
            'email'                 =>  'required|email',
            'password'              =>  'required|min:8|max:50',
        ]);

        if($validator->fails())
        {
            return $this->errorResponce(224, $validator->messages());
        }

        $user = User::query()->create([
            'name'  =>  $request->input('name'),
            'email' =>  $request->input('email'),
            'password'  =>  Hash::make($request->password),
        ]);

        return $this->successResponce(201, (new UserResource($user)), 'Create new user successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->successResponce('200', (new UserResource($user)), 'show user successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'name'                  =>  'required|min:3|max:100|string',
            'email'                 =>  'required|email',
            'password'              =>  'required|min:8|max:50',
        ]);

        if($validator->fails())
        {
            return $this->errorResponce(224, $validator->messages());
        }

        $user->query()->update([
            'name'      =>  $request->input('name'),
            'email'     =>  $request->input('email'),
            'password'  =>  Hash::make($request->password),
        ]);

        return $this->successResponce(201, (new UserResource($user)), 'update user successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponce('204', (new UserResource($user)), 'Delete user successfully.');
    }
}
