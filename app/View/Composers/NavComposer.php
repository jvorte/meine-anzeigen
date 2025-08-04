<?php 
namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NavComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $unreadCount = 0;

        if ($user) {
            $unreadCount = $user->unreadMessagesCount();
        }

        $view->with('unreadMessagesCount', $unreadCount);
    }
}
