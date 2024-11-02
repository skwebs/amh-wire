<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CropImageController extends Controller
{
    public function crop(){
        return view('crop-image');
    }
}
