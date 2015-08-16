<?php
namespace App\Api;

use Config;
use RuDev\Api;
use RuDev\Http\Guzzle as HttpClient;
use URL;


class RuDev
{
    /**
     * @var RuDev
     */
    protected static $instance = null;

    /**
     * @return RuDev
     */
    public static function get()
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    private $client;

    /**
     * @return RuDev
     */
    private function __construct()
    {
        $this->client = new Api(
            Config::get('rudev.id'),
            Config::get('rudev.secret'),
            [
                HttpClient::OPT_VERIFY => false,
            ]
        );
    }

    /**
     * @param string $route
     * @return string
     */
    public function getAuthLink($route = 'auth.login')
    {
        return $this->client->getAuthLink([], URL::route($route));
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->client;
    }
}
