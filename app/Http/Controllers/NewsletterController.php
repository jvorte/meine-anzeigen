<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber; // Make sure this model exists or you use another method

class NewsletterController extends Controller
{
    /**
     * Handle the newsletter subscription request.
     */
    public function subscribe(Request $request)
    {
        // Validate the email address
        $request->validate([
            'email' => ['required', 'email', 'unique:newsletter_subscribers,email'],
        ]);

        // Here, you would save the email to your database.
        // For example, if you have a NewsletterSubscriber model:
        NewsletterSubscriber::create([
            'email' => $request->email,
        ]);

        // You can also integrate with an external service like Mailchimp here.

        // Redirect back with a success message
        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}