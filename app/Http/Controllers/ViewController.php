<?php
namespace App\Http\Controllers;

class ViewController extends AbstractController
{
    public function get($name)
    {
        $name = str_replace(['..', '/', '\\'], '.', $name);

        return view('page.ajax.' . $name);
    }
}
