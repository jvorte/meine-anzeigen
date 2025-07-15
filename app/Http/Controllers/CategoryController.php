<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Φόρτωσε τις αγγελίες της κατηγορίας, πχ 10 τελευταίες
      

        return view('categories.show', compact('category'));
    }
}
