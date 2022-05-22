<?php
// unlink('installer.php');
echo "\n";

if(phpversion() < json_decode(file_get_contents("https://update.pmmp.io/api"),true)['php_version']) {
    die("[PMMPInstaller] Error: Your PHP version is outdated and cannot run the latest version of PocketMine-MP. Please upgrade your PHP to continue");
}

// dev mode, activate by adding "dev" to the end of the command
// dev mode ignores the counter
if(isset($argv[1]) && $argv[1] === "dev") {
 $dltimes = "null";
 echo "\nDev mode activated\n";
} elseif(isset($argv[1]) && $argv[1] === "startfile") {

    if(file_exists(".failed")) {
        if(file_get_contents(".failed")) {
            unlink('.failed');
            die();
        }
    }

    $api = json_decode(file_get_contents("https://update.pmmp.io/api"),true);
    $oldversion = file_get_contents(".version");
    $version = $api['base_version'];
    if($version > $oldversion) {
        $lessurl = "https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/";
        $url = $api['download_url'];
        unlink('PocketMine-MP.phar');
        copy($url, "PocketMine-MP.phar");
        file_put_contents(".version", $version);
        echo "[PMMPInstaller] Updated from version $oldversion to $version\n";
        die();
    } else {
        die("[PMMPInstaller] AutoUpdate: You're up to date!\n");
    }
}

$api = json_decode(file_get_contents("https://update.pmmp.io/api"),true);
$url = $api['download_url'];
$lessurl = "https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/";
    
    if(file_exists(".version")) { 
        if(file_get_contents(".version") < $api['base_version']) {
            echo "[PMMPInstaller] Updating...";
            copy($url, "PocketMine-MP.phar");
            copy($lessurl."start.cmd", "start.cmd");
            copy($lessurl."start.ps1", "start.ps1");
            copy($lessurl."start.sh", "start.sh");
            file_put_contents(".version", $api['base_version']);
            echo "\n[PMMPInstaller] Updated to the latest version";
            exit();                 
        } else {
            die("[PMMPInstaller] Error: You are already up to date!\n[PMMPInstaller] If you do not have an install here try deleting '.version'");
        }
    }
    if(!isset($dltimes)) { $dltimes = json_decode(file_get_contents("https://api.countapi.xyz/update/pmmpinstaller.cf/5b01a783-a15f-4aa3-a534-36cc79988fe3?amount=1"),true)['value']; }
    
    $dltimesend =(int) mb_substr($dltimes, strlen($dltimes)-1);
    
    if($dltimesend === 1) { $dltimes = $dltimes."st"; } elseif($dltimesend === 2) { $dltimes = $dltimes."nd"; } elseif($dltimesend === 3) { $dltimes = $dltimes."rd"; } else { $dltimes = $dltimes."th"; }

    $installerversion = json_decode(file_get_contents("https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/version.json"), true)['version'];

    echo "Welcome to PMMPInstaller by tpguy825!\n\nYou are using version $installerversion and was the $dltimes person to download this.\n\n"; 

    echo "Downloading latest PMMP version (".$api['base_version'].") for MC version (".$api['mcpe_version'].")\n";

    copy($url, "PocketMine-MP.phar");
    copy($lessurl."start.cmd", "start.cmd");
    copy($lessurl."start.ps1", "start.ps1");
    copy($lessurl."start.sh", "start.sh");
    file_put_contents(".version", $api['base_version']);
    exit('Done! Run start.cmd, start.sh or start.ps1 to continue.');
