<?php
namespace RuDev;

use Config;
use UplFile;

/**
 * Class FileSync
 * @package RuDev
 */
class FileSync
{
    // Не синхронизированный файл
    const SYNC_SERVER_DEFAULT     = 0;

    // В стадии синхронизации
    // - для блокировки перезаписи в режиме мультитредов
    const SYNC_SERVER_PROGRESS    = 1;

    // Ошибка синхронизации (файл остаётся локально)
    const SYNC_SERVER_LOCAL       = 2;

    // Инстансы соединений
    protected $servers = [];

    // Клиенты доступа к серверам
    protected $clients = [];


    public function __construct()
    {
        $this->attachClient('yandex', function($config){
            $connection = new \Ya\Disk\Connection(
                $config['login'],
                $config['password']
            );
            return new \Ya\Disk\Disk($connection);
        })->loadConfigs(3, 'sync.ya-disk-1');

    }

    /**
     * Приаттачить клиент
     * @param $id
     * @param callable $cb
     * @return $this
     */
    public function attachClient($id, callable $cb)
    {
        $this->clients[$id] = $cb;
        return $this;
    }

    /**
     * Загрузить соединение
     * @param $id
     * @param $configId
     * @return $this
     */
    public function loadConfigs($id, $configId)
    {
        $conf   = Config::get($configId);
        $client = $this->clients[$conf['client']];
        $this->servers[$id] = $client($conf);
        return $this;
    }


    /**
     * Проверить наличие свободных файлов
     */
    public function check()
    {
        $file = UplFile
            ::where('sync_server', '=', self::SYNC_SERVER_DEFAULT)
            ->first();

        if ($file) {
            $connection = array_rand($this->servers);
            $file->update(['sync_server' => self::SYNC_SERVER_PROGRESS]);

            $response = $this->servers[$connection]
                ->upload(public_path(), $file->path);

            if ($response) {
                $file->update([
                    'sync_server' => $connection,
                    'path' => $response
                ]);
            } else {
                $file->update([
                    'sync_server' => self::SYNC_SERVER_LOCAL
                ]);
            }
        }
    }


    public function download($file)
    {
        if (
            in_array($file->sync_server, [
                self::SYNC_SERVER_DEFAULT,
                self::SYNC_SERVER_LOCAL,
                self::SYNC_SERVER_PROGRESS
            ])
        ) {
            return file_get_contents(
                public_path($file->path)
            );
        }

        return $this->servers[$file->sync_server]
            ->download($file->path);
    }
}