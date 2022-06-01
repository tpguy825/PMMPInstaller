<?php

class GetVersionInfo {
    private $vi
    public function __construct($vi) {
        $this->vi = $vi;
    }

    public function getversion() {
        return $this->vi->BASE_VERSION;
    }
}

try {
    $phar = new Phar('./PocketMine-MP.phar');
    $phar->extractTo('./pmmp-phar', 'src/VersionInfo.php', true);
    require('./pmmp-phar/src/VersionInfo.php');
    $version = (new GetVersionInfo(new VersionInfo))->getversion();
    echo $version;
} catch (PharException $e) {
    echo $e;
}
