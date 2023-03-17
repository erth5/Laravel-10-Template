<?php

namespace App\Services;

use Illuminate\Http\Request;


/**
 * Class ImageService.
 */
class ImageService
{
    public function imageExist(Request $request)
    {
        // $request->validate ist eine Methode von Request
        $validatedExistence = $request->validate([
            'image' => 'required',
        ]);
        return $validatedExistence;
    }

    public function imageValid(Request $request)
    {
        $validatedImage = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg,bmp,application/pdf|max:2048',
        ]);
        return $validatedImage;
    }
}
