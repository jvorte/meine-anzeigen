<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Http\Request;

class BoatController extends Controller
{
    /**
     * Display a listing of boats.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $boats = Boat::orderBy('created_at', 'desc')->paginate(12); // Paginate for larger datasets
        $categories = Category::all(); // For navigation

        return view('categories.boote.index', compact('boats', 'categories'));
    }

    /**
     * Display the specified boat.
     *
     * @param  \App\Models\Boat  $boat
     * @return \Illuminate\View\View
     */
    public function show(Boat $boat)
    {
        $categories = Category::all(); // For navigation
        return view('categories.boote.show', compact('boat', 'categories'));
    }

    // You can add create, store, edit, update, destroy methods here as needed
}
