<?php

// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // This is a much cleaner way to handle the dynamic model loading.
        // It assumes your category slug matches your model names (e.g., 'cars' -> 'Car').
        $modelName = 'App\\Models\\' . Str::studly(Str::singular($category->slug));

        // Check if the model exists to prevent errors
        if (!class_exists($modelName)) {
            // Handle the case where the model does not exist
            return redirect()->route('dashboard')->with('error', 'Category not found.');
        }

        // Load the ads for the specific model
        $ads = $modelName::with('images')->orderBy('created_at', 'desc')->paginate(12);

        // Pass the ads and category to the view
        return view('categories.show', compact('category', 'ads'));
    }
}