<?php
namespace App\Document\Drivers;

/**
 * Interface DriverInterface
 * @package App\Document\Drivers
 */
interface DriverInterface
{
    /**
     * @param string $mime
     * @return bool
     */
    public function match($mime);

    /**
     * @return string
     */
    public function getPreviewUrl();
}
