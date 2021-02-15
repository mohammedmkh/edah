<?php

namespace App\Providers;

use App\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


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

        Schema::defaultStringLength(191);

        $languages = Language::where('status' ,1)->get();
        view()->composer('*',function($view)
           use($languages) {

            $view->with('languages', $languages);


        });

    }
}
