<?php

declare(strict_types=1);

namespace App\Modules\Products\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ProductServiceProvider extends ServiceProvider
{
    //TASK ASSIGNMENT: MODULE ARCHITECTURE FOUNDATION (Member 1 - Billiones)
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Load Routes
        if (file_exists(base_path('app/Modules/Products/routes.php'))) {
            Route::middleware('web')
                ->group(base_path('app/Modules/Products/routes.php'));
        }

        // 2. Load Migrations
        if (is_dir(base_path('app/Modules/Products/database/migrations'))) {
            $this->loadMigrationsFrom(base_path('app/Modules/Products/database/migrations'));
        }

        // 3. Load Views Namespace
        // 🚨 ADJUST THIS PATH TO MATCH YOUR ACTUAL FOLDER NAME EXACTLY:
        $viewPath = base_path('app/Modules/Products/Resources/views'); 
        
        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, 'products');
        }
    }
}