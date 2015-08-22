<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class TextDriver
 * @package App\Document\Formats
 */
class TextDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'text/plain'
    ];

    /**
     * @var string
     */
    protected $alias = ':text:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/text.png';


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