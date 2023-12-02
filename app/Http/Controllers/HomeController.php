<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view_home(Request $request) {
        return view('home');
    }
    public function view_image_disk(Request $request) {
        return view('image-disk');
    }
    public function view_image_blob(Request $request) {
        return view('image-blob');
    }
}
