<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Size;
use App\Data\Repositories\SizeRepository;

class SizeRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('SizeRepository', function () {
            return new SizeRepository(new Size);
        });

    }
}
