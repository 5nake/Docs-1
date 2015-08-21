<?php
namespace App\Http\Controllers;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends AbstractController
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('page.preloader');
    }
}
