<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\Event;
use App\Data\Repositories\EventRepository;

class EventRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('EventRepository', function () {
            return new EventRepository(new Event);
        });

    }
}
