<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFilesStructure extends Migration
{
    public function up()
    {
        $files = DB::table('files')->get();
        foreach ($files as $file) {
            echo $file->id . "\n";

            $file->path = str_replace('/uploads', '', $file->path);
            switch ($file->preview) {
                case '/img/formats/default.png':
                case '/img/icons/undefined.png':
                    $file->preview = ':default:';
                    break;
                case '/img/formats/binaries.png':
                    $file->preview = ':bin:';
                    break;
                case '/img/formats/audio.png':
                    $file->preview = ':audio:';
                    break;
                case '/img/formats/video.png':
                    $file->preview = ':video:';
                    break;
                default:
                    $file->preview = str_replace('/uploads', '', $file->preview);
            }
            $file->token = strlen($file->token) > 32
                ? md5(mt_rand(0, PHP_INT_MAX) . microtime())
                : $file->token;

            DB::table('files')
                ->where('id', $file->id)
                ->update(
                    (array)$file
                );
        }
    }

    public function down()
    {
        $files = DB::table('files')->get();
        foreach ($files as $file) {
            echo $file->id . "\n";

            $file->path = '/uploads' . $file->path;
            switch ($file->preview) {
                case ':default:':
                    $file->preview = '/img/formats/default.png';
                    break;
                case ':bin:':
                    $file->preview = '/img/formats/binaries.png';
                    break;
                case ':audio:':
                    $file->preview = '/img/formats/audio.png';
                    break;
                case ':video:':
                    $file->preview = '/img/formats/video.png';
                    break;
                default:
                    $file->preview = '/uploads' . $file->preview;
            }
            DB::table('files')
                ->where('id', $file->id)
                ->update(
                    (array)$file
                );
        }
    }
}
