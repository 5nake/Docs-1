<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class DocDriver
 * @package App\Document\Formats
 */
class FontDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'text/x-c',                     // FNT
        'font/opentype',                // OTF
        'font/ttf',                     // TTF
        'application/font-woff',        // WOFF
        'application/vnd.ms-fontobject',// EOT
    ];

    /**
     * @var string
     */
    protected $alias = ':font:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/font.png';


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