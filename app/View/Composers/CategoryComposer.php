<?php

namespace App\View\Composers;

use App\Models\Category; // Assuming your Category model is in App\Models
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $categories = Category::all(); // Fetch all categories
        $view->with('categories', $categories);
    }
}