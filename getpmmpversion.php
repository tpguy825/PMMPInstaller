<?php

/**
 * @param string $pmmpfile Filename of 'PocketMine-MP.phar'
 * 
 * @return string|bool Returns version on success, false on error
 */
function getVersion($pmmpfile) {
        try {
            // $tempfoldername = hash("sha256", random_int(1, 100));
            $tempfoldername = hash("sha256", 1);
            $phar = new Phar($pmmpfile);
            $phar->extractTo("./$tempfoldername", 'src/VersionInfo.php', true);
            copy("./$tempfoldername/src/VersionInfo.php", "VersionInfo.php");
            rmdir("./$tempfoldername");
            $version = (new GetVersionInfo("VersionInfo.php"))->getversion(new VersionInfo(include "VersionInfo.php"));
            return $version;
        } catch (PharException $e) {
            return false;
        }
    }
    
class GetVersionInfo {
    
    function getversion($version) {
        return VersionInfo::BASE_VERSION;
    }
}