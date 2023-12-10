<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;


class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponce(200, Post::all(), 'Get All Data Successfully.');
    }

}
