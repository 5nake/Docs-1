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
        'image/jpeg'    => 'RuDev\Render\Image',
        'image/jpg'     => 'RuDev\Render\Image',
        'image/gif'     => 'RuDev\Render\Image',
        'image/png'     => 'RuDev\Render\Image',
    ];


    protected $file;


    public function __construct($file)
    {
        $this->file = $file;
    }

    public function getResponse()
    {
        if (isset($this->types[$this->file->mime])) {
            $render = new $this->types[$this->file->mime]($this->file);
            return $render->response();
        }

        return Response::download(
            public_path($this->file->path),
            $this->file->title
        );
    }

    public static function create($file)
    {
        return (new static($file))->getResponse();
    }
}
