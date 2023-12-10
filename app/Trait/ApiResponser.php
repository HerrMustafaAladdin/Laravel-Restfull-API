<?php

namespace App\Traits;


trait ApiResponser
{
    protected function successResponce($code, $data, $message = null)
    {
        return response()->json([
            'status'    =>  'success',
            'message'   =>  $message,
            'data'      =>  $data
        ], $code);
    }


    protected function errorResponce($code, $message)
    {
        return response()->json([
            'status'    =>  'error',
            'message'   =>  $message,
            'data'      =>  NULL
        ], $code);
    }
}
