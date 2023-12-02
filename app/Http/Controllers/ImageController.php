<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt' => 'nullable|string',
        ]);

        $imageName = time().'.'.$request->file->extension();  

        $request->file->move(public_path('images'), $imageName);

        // Get image dimensions
        $imagePath = public_path("images/$imageName");
        list($width, $height) = getimagesize($imagePath);

        // Get the URL using the storage helper
        $imageUrl = asset("images/$imageName");
        $altText = $request->input('alt', 'Image Alt Text');

        return response()->json([
            'location' => $imageUrl,
            'alt' => $altText,
            'dimensions' => ['width' => $width, 'height' => $height],
            'fileinput' => [
                // Optionally provide additional information about the file
                // You can leave this empty or provide relevant information
                // based on your application's needs.
            ],
        ]);
    }
}
