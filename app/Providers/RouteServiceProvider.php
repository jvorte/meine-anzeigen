<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    // ... other properties

    /**
     * Define your route model bindings, and other route configuration.
     */
    public function boot(): void
    {
        // This is the correct way to load web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

   Route::model('vehicles_part', \App\Models\UsedVehiclePart::class);
    }

    // ... other methods
}