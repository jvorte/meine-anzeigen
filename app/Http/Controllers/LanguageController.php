<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(string $locale)
    {
        // You can add validation here to ensure the locale is supported
        if (! in_array($locale, ['en', 'de'])) {
            abort(400); // Invalid locale
        }

        Session::put('locale', $locale);

        return redirect()->back();
    }
}