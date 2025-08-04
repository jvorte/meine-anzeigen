<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Μοιράζει τη μεταβλητή unreadMessagesCount σε ΟΛΕΣ τις views
        View::composer('*', function ($view) {
            $user = Auth::user();
            $unreadMessagesCount = $user ? $user->unreadMessagesCount() : 0;
            $view->with('unreadMessagesCount', $unreadMessagesCount);
        });
    }
}
