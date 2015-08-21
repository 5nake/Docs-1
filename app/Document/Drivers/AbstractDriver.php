<?php
namespace App\Document\Drivers;

/**
 * Interface AbstractDriver
 * @package App\Document\Drivers
 */
abstract class AbstractDriver implements DriverInterface
{
    const PREVIEW_DEFAULT = '/img/formats/default.png';
    const PREVIEW_AUDIO   = '/img/formats/audio.png';
    const PREVIEW_BINARY  = '/img/formats/binaries.png';
    const PREVIEW_VIDEO   = '/img/formats/video.png';

    /**
     * @var array
     */
    protected $mimes = [];

    /**
     * @param string $mime
     * @return bool
     */
    public function match($mime)
    {
        return in_array($mime, $this->mimes, true);
    }

    /**
     * @return string
     */
    abstract public function getPreviewUrl();
}
