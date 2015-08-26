<?php
namespace App\Contracts;

use App\Document;
use App\Document\Formats\AbstractDriver;
use App\Document\Formats\DriverInterface;

/**
 * Interface DocumentManagerContract
 * @package App\Contracts
 */
interface DocumentManagerContract
{
    /**
     * @param DriverInterface $driver
     * @return mixed
     */
    public function addDriver(DriverInterface $driver);

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
