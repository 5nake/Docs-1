<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class HtmlDriver
 * @package App\Document\Formats
 */
class HtmlDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'text/html'
    ];

    /**
     * @var string
     */
    protected $alias = ':html:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/html.png';


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