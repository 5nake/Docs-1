<?php

namespace App\Providers;

use App\Contracts\DocumentManagerContract;
use App\Document\DocumentManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(DocumentManagerContract::class, function(){
            return new DocumentManager();
        });
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
