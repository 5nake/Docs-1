<?php
namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use App\View\Composer\EnvironmentComposer;

/**
 * Class ComposerServiceProvider
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layout.master'], EnvironmentComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
