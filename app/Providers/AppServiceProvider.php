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
    // View::composer('layouts.navigation', function ($view) {
    //     $userId = Auth::id();

    //     $categories = Category::all();

    //     $unreadMessagesCount = 0;
    //     if ($userId) {
    //         $unreadMessagesCount = Message::whereNull('read_at')
    //             ->where('user_id', '!=', $userId)
    //             ->whereHas('conversation', function ($query) use ($userId) {
    //                 $query->where('sender_id', $userId)
    //                       ->orWhere('receiver_id', $userId);
    //             })->count();
    //     }

    //     $view->with(compact('categories', 'unreadMessagesCount'));
    // });
}
}
