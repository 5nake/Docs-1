<?php

namespace App\Console\Commands;

use App\Document;
use Illuminate\Console\Command;
use App\Document\DocumentManager;
use App\Document\Formats\AbstractDriver;

/**
 * Class SyncMimeTypes
 * @package App\Console\Commands
 */
class SyncMimeTypes extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sync:mime';

    /**
     * @var string
     */
    protected $description = 'Sync previews with mime types';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Document::all();
        foreach ($files as $file) {
            $this->sync($file);
            $file->save();
        }
    }

    /**
     * @param Document $file
     */
    protected function sync(Document $file)
    {
        (new DocumentManager())
            ->each(function(AbstractDriver $driver) use ($file) {
                if ($driver->matchMime($file) && $driver->getAlias()) {
                    echo $file->mime . ' => ' . $driver->getAlias() . "\n";
                    $file->preview = $driver->getAlias();
                }
            });
    }
}
