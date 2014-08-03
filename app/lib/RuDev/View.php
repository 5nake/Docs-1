<?php
/**
 * This file is part of OAuth package.
 *
 * Serafim <nesk@xakep.ru> (30.06.2014 11:47)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RuDev;

use Session;
use Request;
use Input;
use Response;
use View as V;

class View
{
    const ERROR         = 'error';
    const DATA_RESPONSE = 'json';

    const DATA_ERROR    = 'error';
    const DATA_SUCCESS  = 'success';


    const DEFAULT_LAYOUT        = 'layouts.master';
    const ERROR_VIEW            = 'error.default';
    const DEFAULT_ERR_TITLE     = 'Something went wrong';
    const DEFAULT_ERR_MESSAGE   = 'Undefined error';
    const DEFAULT_TITLE         = 'RuDev Docs';

    /**
     * @param null $view
     * @return bool
     */
    public static function isDataResponse($view = null)
    {
        return (Input::get('ajax') || Request::ajax() || $view == self::DATA_RESPONSE);
    }

    /**
     * @param $view
     * @param $data
     * @param null $code
     * @return array|\Illuminate\View\View
     */
    public static function result($view, $data, $code = null)
    {
        if ($view === self::ERROR) {
            if (is_string($data)) {
                $data = ['message' => $data];
            }

            $data['title'] = (isset($data['title']) && $data['title'])
                ? $data['title']
                : self::DEFAULT_ERR_TITLE;

            $data['message'] = (isset($data['message']) && $data['message'])
                ? $data['message']
                : self::DEFAULT_ERR_MESSAGE;
        }

        if ($code !== null) {
            $data['code'] = $code;
        }

        if (self::isDataResponse($view)) {
            return [
                'status'=> ($view === self::ERROR)
                        ? self::DATA_ERROR
                        : self::DATA_SUCCESS,
                'data'  => $data
            ];
        }

        if ($view === self::ERROR) {
            return self::view(self::ERROR_VIEW, $data, $code);
        }

        return self::view($view, $data, $code);
    }


    /**
     * @param $name
     * @param array $args
     * @param null $code
     * @return \Illuminate\View\View
     */
    protected static function view($name, $args = [], $code = null)
    {
        $args = array_merge([
                'title' => self::DEFAULT_TITLE
            ], $args);
        foreach ($args as $argName => $val) { V::share($argName, $val); }


        $layout = V::make(self::DEFAULT_LAYOUT);
        $layout->content = V::make($name);

        if ($code === null) {
            return $layout;
        }
        return Response::make($layout, $code);
    }



    /**
     * @param $view
     * @param array $args
     * @param null $code
     * @return array
     */
    public static function make($view, $args = [], $code = null)
    {
        return self::result($view, $args, $code);
    }

    /**
     * @param array $args
     * @param null $code
     * @return array
     */
    public static function success($args = [], $code = null)
    {
        return self::result(self::DATA_RESPONSE, $args, $code);
    }

    /**
     * @param array $args
     * @param null $code
     * @return array
     */
    public static function error($args = [], $code = null)
    {
        return self::result(self::ERROR, $args, $code);
    }
}
