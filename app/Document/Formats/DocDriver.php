<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class DocDriver
 * @package App\Document\Formats
 */
class DocDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
    ];

    /**
     * @var string
     */
    protected $alias = ':doc:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/doc.png';


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