<?php
namespace App\Contracts;

use App\Document;
use App\Document\Formats\AbstractDriver;

/**
 * Interface DocumentManagerContract
 * @package App\Contracts
 */
interface DocumentManagerContract
{
    /**
     * @param AbstractDriver $driver
     * @return mixed
     */
    public function addDriver(AbstractDriver $driver);

    /**
     * @param callable $cb
     * @return mixed
     */
    public function each(callable $cb);

    /**
     * @param Document $document
     * @return mixed
     */
    public function fromPreview(Document $document);

    /**
     * @param Document $document
     * @return mixed
     */
    public function toPreview(Document $document);
}
