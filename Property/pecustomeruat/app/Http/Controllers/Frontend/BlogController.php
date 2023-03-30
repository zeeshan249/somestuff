<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blogs(){
       
        return view('Frontend.blogs');
    }
    public function blogdetail(){
       
        return view('Frontend.blogdetails');
    }
}
