<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2048',
            'alt' => 'nullable|string',
        ]);

            // Check if the uploaded file has a valid extension
        $validExtensions = ['jpeg', 'png', 'jpg'];
        $fileExtension = $request->file->getClientOriginalExtension();

        if (!in_array($fileExtension, $validExtensions)) {
            return response()->json(['errorMessage' => 'Invalid file extension. Allowed extensions: jpeg, png, jpg'], 400);
        }

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
