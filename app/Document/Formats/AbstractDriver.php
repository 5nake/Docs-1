<?php
namespace App\Document\Formats;

use App\Document;

/**
 * Class AbstractDriver
 * @package App\Document\Formats
 */
abstract class AbstractDriver implements DriverInterface
{
    /**
     * @var array
     */
    protected $mimes = [];

    /**
     * @return array
     */
    public function getMimeTypes()
    {
        return $this->mimes;
    }

    /**
     * @var string
     */
    protected $alias = null;

    /**
     * @return array
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @var string
     */
    protected $preview = null;

    /**
     * @return array
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param Document $document
     * @return bool
     */
    final public function matchMime(Document $document)
    {
        return in_array($document->mime, $this->mimes, true);
    }

    /**
     * @param Document $document
     * @return bool
     */
    final public function matchAlias(Document $document)
    {
        return $this->alias === $document->real_preview;
    }

    /**
     * @param Document $document
     * @return bool
     */
    final public function match(Document $document)
    {
        return
            $this->matchAlias($document) ||
            $this->matchMime($document);
    }

    /**
     * @param Document $document
     * @return string
     */
    abstract public function toPreview(Document $document);


    /**
     * @param Document $document
     * @return string|null
     */
    abstract public function fromPreview(Document $document);
}
