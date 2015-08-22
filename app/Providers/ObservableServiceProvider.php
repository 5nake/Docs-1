<?php

namespace App\Providers;

use App\Document;
use Illuminate\Support\ServiceProvider;
use App\Observables\DocumentObservable;

/**
 * Class ObservableServiceProvider
 * @package App\Providers
 */
class ObservableServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Document::observe(new DocumentObservable());
    }

    /**
     * @return void
     */
    public function register()
    {

    }
}
