<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Order;
use App\Data\Repositories\OrderRepository;

class OrderRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('OrderRepository', function () {
            return new OrderRepository(new Order);
        });
    }
}
