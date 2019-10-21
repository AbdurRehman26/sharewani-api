<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Category;
use App\Data\Repositories\CategoryRepository;

class CategoryRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('CategoryRepository', function () {
            return new CategoryRepository(new Category);
        });
    }
}
