<?php
namespace App\Document\Formats;
use App\Document;

/**
 * Class VideoDriver
 * @package App\Document\Formats
 */
class VideoDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'video/mpeg',
        'video/mp4',
        'video/ogg',
        'video/quicktime',
        'video/webm',
        'video/x-ms-wmv',
        'video/x-flv',
    ];

    /**
     * @var string
     */
    protected $alias = ':video:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/video.png';


    /**
     * @param Document $document
     * @return string
     */
    public function toPreview(Document $document)
    {
        if ($this->match($document)) {
            return $this->alias;
        }
    }

    /**
     * @param Document $document
     * @return string
     */
    public function fromPreview(Document $document)
    {
        if ($this->match($document)) {
            return $this->preview;
        }
    }
}