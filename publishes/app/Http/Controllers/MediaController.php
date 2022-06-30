<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageCache;

class MediaController extends Controller
{
    /**
     * Get media conversions.
     *
     * @param  Request $request
     * @param  string  $id
     * @param  string  $file
     * @return void
     */
    public function conversion(Request $request, $id, $file)
    {
        $path = storage_path("app/public/{$id}/{$file}");

        if (! file_exists($path)) {
            abort(404);
        }

        $img = Image::cache(function (ImageCache $image) use ($path, $request) {
            $img = $image->make($path);

            $h = $request->h;
            $w = $request->w;
            if ($h || $w) {
                $img->resize($w, $h, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }, 60 * 24 * 365, true);

        return $img->response();
    }
}
