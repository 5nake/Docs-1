<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class DriverInterface
 * @package App\Document\Formats
 */
interface DriverInterface
{
    /**
     * @param Document $document
     * @return string
     */
    public function toPreview(Document $document);


    /**
     * @param Document $document
     * @return string|null
     */
    public function fromPreview(Document $document);
}
