<?php

namespace App\Providers;

use App\Notification;
use App\Category;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->share("categorys", Category::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
