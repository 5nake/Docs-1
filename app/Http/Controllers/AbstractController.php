<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    public static function method($name)
    {
        return '\\' . static::class . '@' . $name;
    }
}
