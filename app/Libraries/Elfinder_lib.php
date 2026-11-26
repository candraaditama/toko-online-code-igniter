<?php

namespace App\Libraries;

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$elfinderPath = __DIR__ . DIRECTORY_SEPARATOR . 'external' . DIRECTORY_SEPARATOR . 'elfinder' . DIRECTORY_SEPARATOR;

foreach ([
    'elFinderSessionInterface.php',
    'elFinderSession.php',
    'elFinderVolumeDriver.class.php',
    'elFinderVolumeLocalFileSystem.class.php',
    'elFinder.class.php',
    'elFinderConnector.class.php',
] as $elfinderFile) {
    if (is_file($elfinderPath . $elfinderFile)) {
        include_once $elfinderPath . $elfinderFile;
    }
}

unset($elfinderPath, $elfinderFile);

class Elfinder_lib
{
    /**
     * @param array<string, mixed> $opts
     */
    public function __construct($opts)
    {
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }
}
