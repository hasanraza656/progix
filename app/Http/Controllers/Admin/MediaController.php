<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Uploader;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /** Image upload used by the rich-text editor. Returns the public URL. */
    public function upload(Request $request)
    {
        $request->validate(['image' => ['required', 'image', 'mimes:'.implode(',', Uploader::MIMES), 'max:5120']]);

        return response()->json(['url' => asset(Uploader::image($request->file('image'), 'blog'))]);
    }
}
