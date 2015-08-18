<?php
namespace App\View\Composer;

use App\Environment;
use Illuminate\View\View;

class EnvironmentComposer
{
    public function compose(View $view)
    {
        $view->with('env', Environment::current());
    }
}
