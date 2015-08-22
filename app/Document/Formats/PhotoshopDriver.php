<?php
namespace App\Document\Formats;

use App\Document;
use App\Document\DocumentManager;

/**
 * Class PhotoshopDriver
 * @package App\Document\Formats
 */
class PhotoshopDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'image/vnd.adobe.photoshop'
    ];

    /**
     * @var string
     */
    protected $alias = ':photoshop:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/photoshop.png';

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