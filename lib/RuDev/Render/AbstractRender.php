<?php
namespace RuDev\Render;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class AbstractRender
 * @package RuDev\Render
 */
abstract class AbstractRender
{
    protected $file;

    /**
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return BinaryFileResponse
     */
    public function response()
    {
        $response = new BinaryFileResponse(public_path($this->file->path));
        $response->setContentDisposition('inline');
        $response->setTtl(300);
        return $response;
    }
}
