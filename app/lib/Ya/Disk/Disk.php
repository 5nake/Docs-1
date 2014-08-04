<?php
namespace Ya\Disk;

use Ya\Disk\Connection;

/**
 * Class Disk
 * @package Ya\Disk
 */
class Disk
{
    protected $client;

    /**
     * @param Connection $client
     */
    public function __construct(Connection $client)
    {
        $this->client = $client;
    }

    /**
     * @param $root
     * @param $path
     * @return array
     * @throws \Exception
     */
    public function upload($root, $path)
    {
        $real = $root . $path;
        $path = '/.rudev/' . str_replace(['\\', '/'], '-', $path);

        $response = $this->client->request(
            'PUT',
            $path,
            file_get_contents($real),
            [
                'Etag' => md5_file($real),
                'Sha256' => hash_file('sha256', $real),
                'Content-Type' => 'application/binary',
                'Expect' => '100-continue'
            ]
        );

        $this->client->request(
            'PROPPATCH',
            $path,
            '<propertyupdate xmlns="DAV:"><set><prop><public_url xmlns="urn:yandex:disk:meta">true</public_url></prop></set></propertyupdate>'
        );


        if ($response['statusCode'] == 401) {
            throw new \Exception('Yandex.Disk configuration failed');
        }

        if ($response['statusCode'] == 201) {
            return $path;
        }

        return null;
    }

    /**
     * @param $path
     */
    public function download($path)
    {
        $response = $this->client->request(
            'GET',
            $path,
            '',
            ['Accept' => '*/*']
        );

        return $response['body'];
    }

    /**
     * @return array
     */
    public function quota()
    {
        return $this->client->propfind('', [
            '{DAV:}quota-available-bytes',
            '{DAV:}quota-used-bytes',
        ]);
    }
}