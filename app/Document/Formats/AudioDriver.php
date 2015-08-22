<?php
namespace App\Document\Formats;
use App\Document;

/**
 * Class AudioDriver
 * @package App\Document\Formats
 */
class AudioDriver extends AbstractDriver
{
    /**
     * @var array
     */
    protected $mimes = [
        'audio/basic',
        'audio/L24',
        'audio/mp4',
        'audio/mpeg',
        'audio/ogg',
        'audio/vorbis',
        'audio/x-ms-wma',
        'audio/x-ms-wax',
        'audio/vnd.rn-realaudio',
        'audio/vnd.wave',
        'audio/webm',
    ];

    /**
     * @var string
     */
    protected $alias = ':audio:';

    /**
     * @var string
     */
    protected $preview = '/img/formats/audio.png';


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