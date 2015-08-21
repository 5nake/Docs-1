<?php
namespace App\Http\Controllers;

/**
 * Class ViewController
 * @package App\Http\Controllers
 */
class ViewController extends AbstractController
{
    /**
     * @param $name
     * @return \Illuminate\View\View
     */
    public function get($name)
    {
        $name = str_replace(['..', '/', '\\'], '.', $name);

        return view('page.ajax.' . $name);
    }
}
