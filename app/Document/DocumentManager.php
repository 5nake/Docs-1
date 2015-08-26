<?php
namespace App\Document;

use App\Document;
use App\Document\Formats\DocDriver;
use App\Document\Formats\FontDriver;
use App\Document\Formats\HtmlDriver;
use App\Document\Formats\TextDriver;
use App\Document\Formats\AudioDriver;
use App\Document\Formats\ImageDriver;
use App\Document\Formats\VideoDriver;
use App\Document\Formats\ArchiveDriver;
use App\Document\Formats\AbstractDriver;
use App\Document\Formats\BinariesDriver;
use App\Document\Formats\PhotoshopDriver;
use App\Document\Formats\DriverInterface;
use App\Contracts\DocumentManagerContract;


/**
 * Class DocumentManager
 * @package App\Document
 */
class DocumentManager implements
    DocumentManagerContract
{
    const UPLOADS_PATH  = '/uploads';
    const DEFAULT_ALIAS = ':default:';
    const DEFAULT_PATH  = '/img/formats/default.png';

    /**
     * @var AbstractDriver[]|DriverInterface[]
     */
    protected $drivers = [];

    /**
     * @return DocumentManager
     */
    public function __construct()
    {
        $this
            ->addDriver(new ArchiveDriver())
            ->addDriver(new AudioDriver())
            ->addDriver(new BinariesDriver())
            ->addDriver(new DocDriver())
            ->addDriver(new FontDriver())
            ->addDriver(new HtmlDriver())
            ->addDriver(new ImageDriver())
            ->addDriver(new PhotoshopDriver())
            ->addDriver(new TextDriver())
            ->addDriver(new VideoDriver());
    }

    /**
     * @param DriverInterface $driver
     * @return $this
     */
    public function addDriver(DriverInterface $driver)
    {
        $this->drivers[] = $driver;

        return $this;
    }

    /**
     * @param callable $cb
     * @return $this
     */
    public function each(callable $cb)
    {
        foreach ($this->drivers as $driver) {
            $cb($driver);
        }

        return $this;
    }

    /**
     * @param Document $document
     * @return mixed|string
     */
    public function fromPreview(Document $document)
    {
        if ($document->real_preview !== static::DEFAULT_ALIAS) {

            foreach ($this->drivers as $driver) {
                if ($result = $driver->fromPreview($document)) {
                    return $result;
                }
            }

        }

        return static::DEFAULT_PATH;
    }

    /**
     * @param Document $document
     * @return mixed|string
     */
    public function toPreview(Document $document)
    {
        foreach ($this->drivers as $driver) {
            if ($result = $driver->toPreview($document)) {
                return $result;
            }
        }

        return static::DEFAULT_ALIAS;
    }
}
