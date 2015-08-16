<?php
namespace App\Http\Controllers;

class DocsController extends AbstractController
{
    public function __construct()
    {

    }

    public function getAllDocuments()
    {
        return \Auth::user()->documents()->latest()->get();
    }
}
