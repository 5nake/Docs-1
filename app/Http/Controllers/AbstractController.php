<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class AbstractController
 * @package App\Http\Controllers
 */
abstract class AbstractController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @param $name
     * @return string
     */
    public static function method($name)
    {
        return '\\' . static::class . '@' . $name;
    }
}
