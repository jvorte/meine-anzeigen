<?php

namespace App\Http\Controllers;

use App\Models\Other;
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Http\Request;

class OtherController extends Controller
{
    /**
     * Display a listing of 'other' items.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $others = Other::orderBy('created_at', 'desc')->paginate(12); // Paginate for larger datasets
        $categories = Category::all(); // For navigation

        return view('categories.sonstiges.index', compact('others', 'categories'));
    }

    /**
     * Display the specified 'other' item.
     *
     * @param  \App\Models\Other  $other
     * @return \Illuminate\View\View
     */
    public function show(Other $other)
    {
        $categories = Category::all(); // For navigation
        return view('categories.sonstiges.show', compact('other', 'categories'));
    }

    // You can add create, store, edit, update, destroy methods here as needed
}
