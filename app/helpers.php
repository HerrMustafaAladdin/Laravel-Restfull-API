<?php

use Carbon\Carbon;

if(!function_exists('generateFileNameImages'))
{
    function generateFileNameImages($fileImage)
    {
        return Carbon::now()->microsecond . "." . $fileImage->extension();
    }
}


if(!function_exists('uploadFileImage'))
{
    function uploadFileImage($request_image, $env_path_name ,$imageName)
    {
        return $request_image->storeAs(env('IMAGE_UPLOAD_PATH') . DIRECTORY_SEPARATOR . $env_path_name , $imageName , 'public');
    }
}
