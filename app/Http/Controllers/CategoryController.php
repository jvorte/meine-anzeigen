<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug) // Not using Route Model Binding here
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all(); // For the navigation bar

        // The view will handle fetching specific ads based on $category->slug
        return view('categories.show', compact('category', 'categories'));
    }
}