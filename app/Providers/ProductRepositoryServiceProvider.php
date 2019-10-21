<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Product;
use App\Data\Repositories\ProductRepository;

class ProductRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('ProductRepository', function () {
            return new ProductRepository(new Product);
        });

    }
}
