<?php
namespace App\Document;

use App\User;
use Auth;
use App\Document;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
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
     * @var File
     */
    private $savedFile;

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
     * @param UploadedFile $file
     * @throws RuntimeException
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;

        if (!$file->isValid()) {
            throw new RuntimeException('Invalid file. The file was damaged.');
        }

        if (!$file->isFile()) {
            throw new RuntimeException('Invalid file data.');
        }


        $hash = md5($file->getClientOriginalName() . mt_rand(0, 9999) . time());

        $this->publicDir  =
            substr($hash, 0, 2) . '/' .
            substr($hash, 2, 2);
        $this->publicName = substr($hash, 4);
        $this->publicUrl  = '/' . $this->publicDir . '/' . $this->publicName;

        $this->publicDir  = public_path(DocumentManager::UPLOADS_PATH . '/' . $this->publicDir);

        $this->savedFile  = $this->file->move($this->publicDir, $this->publicName);
    }

    /**
     * @param User $user
     * @throws FileException
     */
    public function save(User $user)
    {
        $document           = new Document();
        $document->user_id  = $user->id;
        $document->title    = $this->file->getClientOriginalName();
        $document->path     = $this->publicUrl;
        $document->mime     = $this->savedFile->getMimeType();
        $document->size     = $this->savedFile->getSize();

        $document->save();
    }
}
