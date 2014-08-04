<?php
namespace RuDev;

use Image;

/**
 * Class Preview
 * @package RuDev
 */
class Preview
{
    const PREVIEW_WIDTH     = 160;
    const PREVIEW_HEIGHT    = 120;
    const PREVIEW_UPLOADS   = '/uploads/';
    const PREVIEW_PATH      = '/img/formats/default.png';
    const PREVIEW_EXT       = 'jpg';

    /**
     * @var array
     */
    protected $types = [
        'image/jpeg'                => 'createImagePreview',
        'image/pjpeg'               => 'createImagePreview',
        'image/gif'                 => 'createImagePreview',
        'image/png'                 => 'createImagePreview',

        'video/mpeg'                => 'createVideoPreview',
        'video/mp4'                 => 'createVideoPreview',
        'video/ogg'                 => 'createVideoPreview',
        'video/quicktime'           => 'createVideoPreview',
        'video/webm'                => 'createVideoPreview',
        'video/x-ms-wmv'            => 'createVideoPreview',
        'video/x-flv'               => 'createVideoPreview',


        'audio/basic'               => 'createAudioPreview',
        'audio/L24'                 => 'createAudioPreview',
        'audio/mp4'                 => 'createAudioPreview',
        'audio/mpeg'                => 'createAudioPreview',
        'audio/ogg'                 => 'createAudioPreview',
        'audio/vorbis'              => 'createAudioPreview',
        'audio/x-ms-wma'            => 'createAudioPreview',
        'audio/x-ms-wax'            => 'createAudioPreview',
        'audio/vnd.rn-realaudio'    => 'createAudioPreview',
        'audio/vnd.wave'            => 'createAudioPreview',
        'audio/webm'                => 'createAudioPreview',


        'application/x-msdownload'  => 'createBinariesPreview',
        'application/zip'           => 'createBinariesPreview',
        'application/x-gzip'        => 'createBinariesPreview',
        'application/octet-stream'  => 'createBinariesPreview',
        'application/x-dosexec'     => 'createBinariesPreview',
    ];

    /**
     * @var string
     */
    protected $result = self::PREVIEW_PATH;

    /**
     * @param $path
     * @param $mime
     */
    public function __construct($path, $mime)
    {
        if (isset($this->types[$mime])) {
            $this->result = call_user_func([
                $this,
                $this->types[$mime]
            ], $path);
        }
    }


    /**
     * @param $path
     * @return string
     */
    public function createImagePreview($path)
    {
        // 160 120

        $dest = self::createHashPath($path, self::PREVIEW_EXT);
        $img  = Image::make(public_path($path));
        $w    = $img->width();
        $h    = $img->height();

        $aspect = $h/($w/self::PREVIEW_WIDTH);

        if ($aspect >= self::PREVIEW_HEIGHT) {
            $img->resize(self::PREVIEW_WIDTH, null, function ($c) {
                $c->aspectRatio();
            });
        } else {
            $img->resize(null, self::PREVIEW_HEIGHT, function ($c) {
                $c->aspectRatio();
            });
        }
        $img->crop(self::PREVIEW_WIDTH, self::PREVIEW_HEIGHT);
        $img->save(public_path($dest->path . $dest->name));

        return $dest->path . $dest->name;
    }

    /**
     * @param $path
     * @return string
     */
    public function createVideoPreview($path)
    {
        return '/img/formats/video.png';
    }


    /**
     * @param $path
     * @return string
     */
    public function createBinariesPreview($path)
    {
        return '/img/formats/binaries.png';
    }

    /**
     * @param $path
     * @return string
     */
    public function createAudioPreview($path)
    {
        return '/img/formats/audio.png';
    }


    /**
     * @param $name
     * @param $ext
     * @return object
     */
    public static function createHashPath($name, $ext)
    {
        $hash = md5($name . mt_rand(0, 9999) . time());

        $dest = substr($hash, 4, 16) . '.' . $ext;
        $path = self::PREVIEW_UPLOADS .
            substr($hash, 0, 2) . '/' .
            substr($hash, 2, 2) . '/';

        if (!is_dir(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        return (object)[
            'path'      => $path,
            'name'      => $dest
        ];
    }

    /**
     * @return mixed|string
     */
    public function convert()
    {
        return $this->result;
    }
}