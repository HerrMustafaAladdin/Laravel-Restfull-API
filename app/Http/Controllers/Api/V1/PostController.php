<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponser;

    /**
        Get All posts
    */
    public function index()
    {
        $posts = Post::query()->paginate(10);
        return $this->successResponce(200, PostResource::collection($posts), 'Get all data successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'     =>  'required|min:3|max:30|string',
            'body'      =>  'required|min:10|max:1000|string',
            'image'     =>  'required|mimes:png,jpg,webp,svg,jpeg',
            'user_id'   =>  'required'
        ]);
        if($validator->fails())
        {
            return $this->errorResponce(224, $validator->messages());
        }

        $imageName = generateFileNameImages($request->image);
        uploadFileImage($request->image, env('POSTS_PATH_NAME'),$imageName);

        $post = Post::query()->create([
            'title'     =>  $request->input('title'),
            'body'      =>  $request->input('body'),
            'image'     =>  $imageName,
            'user_id'   =>  $request->input('user_id')
        ]);

        return $this->successResponce('201', (new PostResource($post)), 'create post successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->successResponce('200', (new PostResource($post)), "Show post with ID : $post->id");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(),[
            'title'     =>  'required|min:3|max:30|string',
            'body'      =>  'required|min:10|max:1000|string',
            'image'     =>  'mimes:png,jpg,webp,svg,jpeg',
            'user_id'   =>  'required'
        ]);

        if($validator->fails())
        {
            return $this->errorResponce(224, $validator->messages());
        }

        if($request->has('image'))
        {
            $imageName = generateFileNameImages($request->image);
            uploadFileImage($request->image, env('POSTS_PATH_NAME'),$imageName);
        }

        $post->query()->update([
            'title'     =>  $request->input('title'),
            'body'      =>  $request->input('body'),
            'image'     =>  $request->has('image') ? $imageName : $post->image,
            'user_id'   =>  $request->input('user_id')
        ]);

        return $this->successResponce('201', (new PostResource($post)), 'updated post successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->successResponce(204, (new PostResource($post)), 'Deleted post successfully.');
    }
}
