<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * since FJR 2021.02.20
         * added per https:/laravel-news.com/laravel-5-4-key-too-long-error
         * to correct problem with Maria db max length
         *
         * edit includes adding: use Illuminate\Support\Facades\Schema;
         */
        Schema::defaultStringLength(191);
    }
}
