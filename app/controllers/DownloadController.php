<?php
use RuDev\View;
use RuDev\Api;
use RuDev\Render;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class HomeController
 */
class DownloadController extends BaseController
{
    /**
     * @param $token
     * @return array
     */
    public function download($token)
    {
        set_time_limit(0);

        $file = UplFile::where('token', '=', $token)->first();
        if (!$file) { return View::error('File not Found'); }
        if (($file->permissions == UplFile::PERM_PRIVATE) &&
            (Auth::guest() || Auth::user()->id != $file->user_id)) {
                return View::error('Permission denied');
        }


        return Render::create($file);
    }

    /**
     * @param $token
     * @return array
     */
    public function stream($token)
    {
        set_time_limit(0);

        $file = UplFile::where('token', '=', $token)->first();
        if (!$file) { return View::error('File not Found'); }
        if (($file->permissions == UplFile::PERM_PRIVATE) &&
            (Auth::guest() || Auth::user()->id != $file->user_id)) {
            return View::error('Permission denied');
        }


        $response = new BinaryFileResponse(public_path($file->path));
        $response->setContentDisposition('inline');
        $response->setTtl(300);
        return $response;
    }
}
