<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Laravue\Models\User;
use App\Data\Repositories\UserRepository;

class UserRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('UserRepository', function () {
            return new UserRepository(new User);
        });

    }
}
