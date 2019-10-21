<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\FabricAge;
use App\Data\Repositories\FabricAgeRepository;

class FabricAgeRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('FabricAgeRepository', function () {
            return new FabricAgeRepository(new FabricAge);
        });

    }
}
