<?php
namespace App\Http\Controllers;

use App\User;
use App\Document\Uploader;
use Illuminate\Http\Request;

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
            ->latest()
            ->get();
    }

    /**
     * @param Request $request
     */
    public function upload(User $user, Request $request)
    {
        $files = $request->files;
        dd($files);
        foreach ($files as $file) {
            $uploder = new Uploader($user, $file);
        }
    }
}
