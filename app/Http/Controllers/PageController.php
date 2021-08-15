<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $blogs = Blog::get();
        return view('welcome', compact('blogs'));
    }
}
