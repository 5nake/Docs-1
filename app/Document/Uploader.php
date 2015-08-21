<?php
namespace App\Document;

use App\Document;
use App\User;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Uploader
 * @package App\Document
 */
class Uploader
{
    const PATH_PUBLIC = '/uploads/';

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $publicDir;

    /**
     * @var string
     */
    private $publicName;

    /**
     * @var string
     */
    private $publicUrl;

    /**
     * @param User $user
     * @param UploadedFile $file
     * @throws RuntimeException
     */
    public function __construct(User $user, UploadedFile $file)
    {
        $this->file = $file;

        $hash = md5($file->getClientOriginalName() . mt_rand(0, 9999) . time());


        $this->publicDir  =
            substr($hash, 0, 2) . '/' .
            substr($hash, 2, 2);
        $this->publicName = substr($hash, 4);
        $this->publicUrl  = $this->publicDir . '/' . $this->publicName;
        $this->publicDir  = public_path($this->publicDir);


        if (!is_dir($this->publicDir)) {
            if (!mkdir($this->publicDir, 0777, true)) {
                throw new RuntimeException('Can not create storage directory.');
            }
        }

        $file->move($this->publicDir, $this->publicName);

        #$document = new Document();
        
    }
}
