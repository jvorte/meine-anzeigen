<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Message;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));
    }

    /**
     * Bootstrap any application services.
     */

public function boot()
{
    // Περίπτωση categories
    View::composer('layouts.navigation', function ($view) {
        $categories = Category::all();

        // Έλεγχος αν ο χρήστης είναι συνδεδεμένος
        $unreadMessagesCount = 0;
        if (Auth::check()) {
            // Υπολογίζουμε τα μη αναγνωσμένα μηνύματα για τον logged in χρήστη
            $unreadMessagesCount = Message::where('user_id', Auth::id())
                                        ->where('read_at', false) // ή όποιο πεδίο δηλώνει μη αναγνωσμένο
                                        ->count();
        }

        $view->with('categories', $categories)
             ->with('unreadMessagesCount', $unreadMessagesCount);
    });
}
}
