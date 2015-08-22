<?php
namespace App\Document\Formats;

use Image;
use App\Document;
use App\Document\DocumentManager;

/**
 * Class ImageDriver
 * @package App\Document\Formats
 */
class ImageDriver extends AbstractDriver
{
    const PREVIEW_WIDTH     = 160;
    const PREVIEW_HEIGHT    = 120;

    /**
     * @var array
     */
    protected $mimes = [
        'image/jpeg',
        'image/pjpeg',
        'image/gif',
        'image/png',
    ];

    /**
     * @param Document $document
     * @return string
     */
    public function toPreview(Document $document)
    {
        if ($this->matchMime($document)) {
            $image  = Image::make(public_path($document->path));
            $dest       = $this->makePreviewPath() . '.jpg';
            $destReal   = public_path(
                DocumentManager::UPLOADS_PATH .
                $dest
            );

            $width  = $image->width();
            $height = $image->height();

            $aspect = $height / ($width / static::PREVIEW_WIDTH);

            if ($aspect >= static::PREVIEW_HEIGHT) {
                $image->resize(static::PREVIEW_WIDTH, null, function ($c) {
                    $c->aspectRatio();
                });
            } else {
                $image->resize(null, static::PREVIEW_HEIGHT, function ($c) {
                    $c->aspectRatio();
                });
            }
            $image->crop(static::PREVIEW_WIDTH, static::PREVIEW_HEIGHT);

            if (!is_dir(dirname($destReal))) {
                @mkdir(dirname($destReal), 0777, true);
            }

            $image->save($destReal, 100);

            return $dest;
        }
    }

    /**
     * @return string
     */
    protected function makePreviewPath()
    {
        $hash = md5(mt_rand(0, PHP_INT_MAX) . microtime());
        return '/' .
            substr($hash, 0, 2) . '/' .
            substr($hash, 2, 2) . '/' .
            substr($hash, 4);
    }

    /**
     * @param Document $document
     * @return string
     */
    public function fromPreview(Document $document)
    {
        $preview = $document->real_preview;

        if (
            $this->match($document) ||
            preg_match('/\/[a-z0-9]{2}\/[a-z0-9]{2}.*/isu', $preview)
        ) {
            return DocumentManager::UPLOADS_PATH . $preview;
        }
    }
}