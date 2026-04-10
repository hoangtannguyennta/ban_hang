<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->take(5)->get();
        return view('fe.layouts.home', compact('categories'));
    }
}