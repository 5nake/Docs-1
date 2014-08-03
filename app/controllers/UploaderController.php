<?php
use RuDev\View;
use RuDev\Api;
use RuDev\Preview;
use RuDev\Render;

/**
 * Class HomeController
 */
class UploaderController extends BaseController
{
    /**
     * @return array
     */
    public function upload()
    {
        $files  = Input::file('files');
        $result = [];

        if (Auth::guest()) {
            return View::error('Wrong permissions');
        }

        if (!is_array($files)) {
            return View::error('Wrong upload format');
        }

        foreach ($files as $file) {
            try {
                $dest = Preview::createHashPath(
                    $file->getFilename(),
                    $file->getClientOriginalExtension()
                );
                $mime = $file->getMimeType();
                $size = $file->getSize();
                $file->move(public_path($dest->path), $dest->name);


                $f = new UplFile;
                $f->user_id     = Auth::user()->id;
                $f->title       = $file->getClientOriginalName();
                $f->permissions = UplFile::PERM_PUBLIC;
                $f->preview     = (new Preview(
                       $dest->path . $dest->name,
                       $mime
                    ))->convert();
                $f->size        = $size;
                $f->path        = $dest->path . $dest->name;
                $f->token       = Hash::make($dest->path . $dest->name);
                $f->mime        = $mime;
                $f->save();

                $result[]       = $f;

            } catch (Exception $e) {
                return View::error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            }
        }

        return View::success(['files' => $result]);
    }

    /**
     * @return array
     */
    public function all()
    {
        if (Auth::guest()) {
            return View::error('Permission denied');
        }

        $files = UplFile::where('user_id', '=', Auth::user()->id)->orderBy('created_at')->get();
        return View::success(['files' => $files->toArray()]);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id)
    {
        if (Input::get('_token') != Session::token()) {
            return View::error('CSRF token mismatch');
        }

        if (Auth::guest()) {
            return View::error('Permission denied');
        }

        $file = UplFile::find($id);

        if (!$file) {
            return View::error('File not found');
        }

        if (Auth::user()->id != $file->user_id) {
            return View::error('Permission denied');
        }


        if (Input::get('title')) {
            $file->title = Input::get('title');
        }
        if (Input::get('permissions')) {
            $file->permissions = Input::get('permissions');
        }
        $file->save();

        return View::success(['file' => $file]);
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        if (Input::get('_token') != Session::token()) {
            return View::error('CSRF token mismatch');
        }

        if (Auth::guest()) {
            return View::error('Permission denied');
        }

        $file = UplFile::find($id);

        if (!$file) {
            return View::error('File not found');
        }

        if (Auth::user()->id != $file->user_id) {
            return View::error('Permission denied');
        }


        unlink(public_path($file->path));
        if (strstr($file->preview, Preview::PREVIEW_UPLOADS)) {
            unlink(public_path($file->preview));
        }
        $file->delete();
        return View::success('success');
    }

    /**
     * @param $token
     * @return array
     */
    public function download($token)
    {
        $file = UplFile::where('token', '=', $token)->first();
        if (!$file) {
            return View::error('File not Found');
        }

        if ($file->permissions == UplFile::PERM_PRIVATE) {
            if (Auth::guest() || Auth::user()->id != $file->user_id) {
                return View::error('Permission denied');
            }
        }

        return Render::create($file);
    }
}