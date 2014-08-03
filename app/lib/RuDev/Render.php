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
    /**
     * @var array
     */
    protected $types = [
        'image/jpeg'    => 'createImageRender',
        'image/jpg'     => 'createImageRender',
        'image/gif'     => 'createImageRender',
        'image/png'     => 'createImageRender',
    ];


    protected $file;


    public function __construct($file)
    {
        $this->file = $file;
    }

    public function getResponse()
    {
        if (isset($this->types[$this->file->mime])) {
            $method = $this->types[$this->file->mime];
            return $this->$method();
        }

        return Response::download(
            public_path($this->file->path),
            $this->file->title
        );
    }

    protected function createImageRender()
    {
        $response = new BinaryFileResponse(public_path(
            $this->file->path
        ));
        $response->setContentDisposition('inline');
        $response->setTtl(300);
        return $response;
    }

    public static function create($file)
    {
        return (new static($file))->getResponse();
    }
}