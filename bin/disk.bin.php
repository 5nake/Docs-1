<?php
use RuDev\FileSync;

require __DIR__ . '/../bootstrap/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/start.php';
$app->setRequestForConsoleEnvironment();
$app->boot();



$fsync = new FileSync();
while (true) {
    $fsync->check();
    sleep(1);
}

$app->shutdown();


