<?php
namespace RuDev\Render;

use RuDev\View;

class Image extends AbstractRender
{
    public function response()
    {
        list($width, $height, $type, $attr) = getimagesize(public_path($this->file->path));

        return View::make('render.image', [
            'title' => $this->file->title,
            'width' => $width,
            'height' => $height,
            'file' => $this->file
        ]);
    }
}
