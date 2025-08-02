<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // Μπορείς να φορτώσεις εδώ τα μηνύματα του χρήστη, για αρχή απλά δείξε μια view
        return view('messages.index');
    }
}
