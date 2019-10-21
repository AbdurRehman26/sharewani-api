<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Brand;
use App\Data\Repositories\BrandRepository;

class BrandRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('BrandRepository', function () {
            return new BrandRepository(new Brand);
        });

    }
}
