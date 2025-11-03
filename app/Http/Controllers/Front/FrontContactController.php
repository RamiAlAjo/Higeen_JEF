<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontContactController extends Controller
{
      public function index()
    {
        // Return the view with all the necessary data, including photos
        return view('front.contact');
    }
}
