<?php

class GetVersionInfo {
    publuc function 
    public function getversion() {
        return VersionInfo::BASE_VERSION;
    }
}

try {
    $phar = new Phar('./PocketMine-MP.phar');
    $phar->extractTo('./pmmp-phar', 'src/VersionInfo.php', true);
    $phar->extractTo('./pmmp-phar', 'src/Server.php', true);
    require('./pmmp-phar/src/Server.php');
    $version = (new Server(new DynamicClassLoader, new AttachableThreadedLogger, "", ""))->getApiVersion();
    echo $version;
} catch (PharException $e) {
    echo $e;
}