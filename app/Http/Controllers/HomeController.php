<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view_home(Request $request) {
        return view('home');
    }
}
