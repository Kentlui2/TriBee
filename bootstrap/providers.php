<?php

use App\Providers\AppServiceProvider;
use App\Modules\Cart\CartServiceProvider;
use App\Modules\Products\Providers\ProductServiceProvider;
use App\Modules\Orders\Providers\OrderServiceProvider;

return [
    AppServiceProvider::class,
    CartServiceProvider::class,
    ProductServiceProvider::class,
    OrderServiceProvider::class,
];
