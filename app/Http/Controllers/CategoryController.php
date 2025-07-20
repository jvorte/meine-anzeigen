<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    // public function show($slug)
    // {
    //     $category = Category::where('slug', $slug)->firstOrFail();

    //     // Φόρτωσε τις αγγελίες της κατηγορίας, πχ 10 τελευταίες
      

    //     return view('categories.show', compact('category'));
    // }

          public function show($slug)
        {
            $category = Category::where('slug', $slug)->firstOrFail();
            $categories = Category::all(); // For the navigation bar

            // The view will handle fetching specific ads based on $category->slug
            return view('categories.show', compact('category', 'categories'));
        }
}
