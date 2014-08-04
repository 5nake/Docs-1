<?php
namespace Ya\Disk;

use Sabre\DAV\Client;
use Sabre\HTTP;

use Exception;

/**
 * Class Connection
 * @package Ya\Disk
 */
class Connection
{
    const DISK_URL = 'http://webdav.yandex.ru';
    #const DISK_URL = 'http://127.0.0.1:8080';

    /**
     * @var \Sabre\DAV\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $auth;

    /**
     * @param string $login
     * @param string $password
     * @throws Exception
     */
    public function __construct($login, $password)
    {
        if (
            !isset($login) ||
            !isset($password)
        ) {
            throw new Exception('Ya.Disk configuration error: Undefined Login or Password');
        }

        $this->auth   = base64_encode($login . ':' . $password);
        $this->client = new Client(['baseUri' => self::DISK_URL]);
        $this->client->addCurlSetting(CURLOPT_SSL_VERIFYPEER, false);
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function mixHeaders(array $headers = [])
    {
        return array_merge(
            $headers,
            ['Authorization' => 'Basic ' . $this->auth]
        );
    }

    /**
     * @param $method
     * @param string $url
     * @param null $body
     * @param array $headers
     * @return array
     */
    public function request($method, $url = '', $body = null, array $headers = [])
    {
        $headers = $this->mixHeaders($headers);
        return $this->client->request($method, $url, $body, $headers);
    }


    /**
     * @param $url
     * @param array $properties
     * @param int $depth
     * @return array
     */
    public function propfind($url, array $properties = [], $depth = 0)
    {
        $body = Format::getPropfind($properties);

        $response = $this->request('PROPFIND', $url, $body, [
            'Depth'         => $depth,
            'Content-Type'  => 'application/xml'
        ]);

        return Format::parse(
            $this->client->parseMultiStatus($response['body']),
            $depth
        );
    }
}