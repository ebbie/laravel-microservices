<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request)
    {
        if(Gate::allows('edit','users')) {
            $file = $request->file('image');
            $name = Str::random(10);
            $url = \Storage::putFileAs('images',$file, $name . '.' . $file->extension());

            return [
                'url' => env('APP_URL') . '/' . $url
            ];

        } else {
            return "cannot upload image";
        }
    }
}
