<?php


namespace App\Traits;

namespace App\Traits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

trait ImageUploadTrait
{
    /**
     * Store single image
     * @param FormRequest $request
     * @return string|null
     */
    public function uploadOne(FormRequest $request, $originalStorePath, $thumbnailStorePath, $imageX, $imageY, $imageName='image') {
        $image = null;
        $imageType = null;
        if ($request->hasFile($imageName) && $request->file($imageName)->isValid()) {
            $file = $request->file($imageName);
            $imageType = $request->file($imageName)->getMimeType();
            $image = \ImageHelper::uploadImage($file,'',$originalStorePath,$thumbnailStorePath,$imageX,$imageY);
            return $image;
        }
        return null;
    }

    public function uploadOneAPI(Request $request, $originalStorePath, $thumbnailStorePath, $imageX, $imageY) {
        $image = null;
        $imageType = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $imageType = $request->file('image')->getMimeType();
            $image = \ImageHelper::uploadImage($file,'',$originalStorePath,$thumbnailStorePath,$imageX,$imageY);
            return $image;
        }
        return null;
    }
}
