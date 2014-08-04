<?php
namespace RuDev;

use Image;
use Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class Preview
 * @package RuDev
 */
class Render
{
    protected $file;

    protected $fsync;

    /**
     * @param $file
     */
    public function __construct($file)
    {
        $this->fsync = (new FileSync());

        $this->file = $file;
    }

    /**
     * @return BinaryFileResponse
     */
    public function getResponse()
    {
        $response = Response::make(
            $this->fsync->download($this->file),
            200,
            [
                'Content-Type' => $this->file->mime,
                'Content-Disposition' => sprintf(
                    'inline; filename="%s"',
                    \Str::ascii($this->file->title)
                )
            ]
        );
        #$disposition, $name, Str::ascii($name)
        $response->setTtl(300);
        return $response;
    }


    /**
     * @param $file
     * @return mixed
     */
    public static function create($file)
    {
        return (new static($file))->getResponse();
    }
}