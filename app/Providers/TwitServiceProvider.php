<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TwitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('twit', function ($app) {
            return new \App\Repo\Twit();
        });
    }
}
