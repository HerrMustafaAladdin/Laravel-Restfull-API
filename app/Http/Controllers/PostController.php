<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return $this->successResponce(200,Post::all(),'get all posts');
        return $this->errorResponce(404,'Not Found !');
    }


    protected function successResponce($code, $data, $message = null)
    {
        return response()->json([
            'status'    =>  'success',
            'message'   =>  $message,
            'data'      =>  $data
        ],$code);
    }

    protected function errorResponce($code, $message)
    {
        return response()->json([
            'status'    =>  'error',
            'message'   =>  $message,
            'data'      =>  NULL
        ],$code);
    }

}
