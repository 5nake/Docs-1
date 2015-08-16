<?php
namespace App\Http\Controllers;

class HomeController extends AbstractController
{
    public function index()
    {
        return view('page.preloader');
    }
}
