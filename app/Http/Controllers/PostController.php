<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponce(200, Post::all(), 'Get All Data Successfully.');
    }

    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'title'     =>  'required|string',
            'body'      =>  'required|string',
            'image'     =>  'required|image',
            'user_id'   =>  'required',
        ]);

        if($validator->fails())
        {
            return $this->errorResponce(422, $validator->messages());
        }

        $imageName = Carbon::now()->microsecond. "." . $request->image->extension();
        $request->image->storeAs('images/posts', $imageName, 'public');

        $post = Post::create([
            'title'     =>  $request->input('title'),
            'body'      =>  $request->input('body'),
            'image'     =>  $imageName,
            'user_id'   =>  $request->input('user_id'),
        ]);

        return $this->successResponce(201, $post, 'Create Post Successfully.');
    }

    public function show(Post $post)
    {
        return $this->successResponce(200,$post,"Get [Post : $post->title] successfully .");
    }

}
