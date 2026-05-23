<?php

use App\Providers\AppServiceProvider;
use App\Modules\Cart\CartServiceProvider;
use App\Modules\Products\Providers\ProductServiceProvider;

return [
    AppServiceProvider::class,
    CartServiceProvider::class,
    ProductServiceProvider::class,
];
