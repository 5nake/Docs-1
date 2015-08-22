<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class ArchiveDriver
 * @package App\Document\Formats
 */
class ArchiveDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'application/zip',      // ZIP
        'application/x-gzip',   // ZIP
        'application/x-rar'     // RAR
    ];

    /**
     * @var string
     */
    protected $alias = ':archive:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/archive.png';


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