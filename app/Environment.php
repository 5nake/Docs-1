<?php
namespace App;

use Config;

/**
 * Class Environment
 * @package App
 */
class Environment
{
    const SIZE_CHARS = 'bkmgtpezy';

    /**
     * @var Environment
     */
    protected static $current = null;

    /**
     * @return null
     */
    public static function current()
    {
        if (static::$current === null) {
            static::$current = new static;
        }
        return static::$current;
    }

    /**
     * @return int
     */
    public function getUploadSize()
    {
        $post   = $this->sizeToBytes(
            ini_get('post_max_size')
        );
        $upload = $this->sizeToBytes(
            ini_get('upload_max_filesize')
        );

        $available = $upload > 0
            ? min($post, $upload)
            : (int)$post;

        return min(Config::get('upload.size'), $available);
    }

    /**
     * @return int
     */
    public function getMaxFilesCount()
    {
        return Config::get('upload.count');
    }


    /**
     * @param $size
     * @return int
     */
    private function sizeToBytes($size)
    {
        $unit = preg_replace(sprintf('/[^%s]/i', static::SIZE_CHARS), '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);

        if ($unit) {
            return round($size * pow(1024, stripos(static::SIZE_CHARS, $unit[0])));
        }
        return round($size);
    }
}
