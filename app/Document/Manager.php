<?php
namespace App\Document;

use App\Document\Drivers\DriverInterface;
use App\Document\Drivers\ImageDocument;

/**
 * Class Manager
 * @package App\Document
 */
class Manager
{
    /**
     * @var DriverInterface[]
     */
    protected $drivers = [];

    /**
     *
     */
    public function __construct()
    {
        $this->addDriver(new ImageDocument());
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

    #public function getPreview()
}
