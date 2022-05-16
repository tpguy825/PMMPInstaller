<?php

// dev mode, activate by adding "dev" to the end of the command
// dev mode ignores the c
if(isset($argv[1]) && $argv[1] === "dev") {
 $dltimes = "null";
 
} else {
$dltimes = json_decode(file_get_contents("https://api.countapi.xyz/update/pmmpinstaller.cf/5b01a783-a15f-4aa3-a534-36cc79988fe3?amount=1"),true)['value'];

$dltimesend =(int) mb_substr($dltimes, strlen($dltimes)-1);
 
if($dltimesend === 1) { $dltimes = $dltimes."st"; } elseif($dltimesend === 2) { $dltimes = $dltimes."nd"; } elseif($dltimesend === 3) { $dltimes = $dltimes."rd" } else { $dltimes = $dltimes."th" }
}

$version = file_get_contents("https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/version.txt");

echo "Welcome to PMMPInstaller by tpguy825!\n\nYou are using version $version and was the $dltimes person to download this.\n\n"; 
$api = json_decode(file_get_contents("https://update.pmmp.io/api"),true);
$url = $api['download_url'];
$lessurl = "https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/";

echo "\nDownloading latest PMMP version (".$api['base_version'].") for MC version (".$api['mcpe_version'].") ";

copy($url, "PocketMine-MP.phar");
copy($lessurl."start.cmd", "start.cmd");
copy($lessurl."start.ps1", "start.ps1");
copy($lessurl."start.sh", "start.sh");

echo "Success! You can now run 'start.cmd', 'start.ps1' or 'start.sh'";
unlink('installer.php');
