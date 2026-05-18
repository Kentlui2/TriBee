<?php

namespace App\Modules\Products\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. FIXED: Added the 'web' middleware group so Laravel can cleanly parse public HTML layout views
        if (file_exists(base_path('app/Modules/Products/routes.php'))) {
            Route::middleware('web')
                ->group(base_path('app/Modules/Products/routes.php'));
        }

        // 2. Automatically load your module's database migrations
        if (is_dir(base_path('app/Modules/Products/database/migrations'))) {
            $this->loadMigrationsFrom(base_path('app/Modules/Products/database/migrations'));
        }

        // 3. Automatically load your module's frontend Blade templates namespace
        if (is_dir(base_path('app/Modules/Products/Resources/views'))) {
            $this->loadViewsFrom(base_path('app/Modules/Products/Resources/views'), 'products');
        }
    }
}