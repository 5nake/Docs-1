<?php
namespace App\Document\Formats;
use App\Document;

/**
 * Class BinariesDriver
 * @package App\Document\Formats
 */
class BinariesDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'application/x-msdownload',
        'application/octet-stream',
        'application/x-dosexec',
    ];

    /**
     * @var string
     */
    protected $alias = ':bin:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/binaries.png';

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