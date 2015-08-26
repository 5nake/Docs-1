<?php
namespace App\Http\Controllers;

use Auth;
use App\Document\Uploader;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class DocsController
 * @package App\Http\Controllers
 */
class DocsController extends AbstractController
{
    /**
     * @return mixed
     */
    public function getAllDocuments()
    {
        return \Auth::user()
            ->documents()
            ->with('tags')
            ->latest()
            ->get();
    }

    /**
     * @param Request $request
     * @throws FileException
     */
    public function upload(Request $request)
    {
        $files = $request->files;

        foreach ($files as $file) {
            $upload = new Uploader($file);
            $upload->save(Auth::user());
        }
    }
}
