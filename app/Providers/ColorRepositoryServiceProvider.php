<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Color;
use App\Data\Repositories\ColorRepository;

class ColorRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('ColorRepository', function () {
            return new ColorRepository(new Color);
        });

    }
}
