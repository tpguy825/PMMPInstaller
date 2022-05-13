<?php

$downloadedamount = json_decode(file_get_contents("https://api.countapi.xyz/update/pmmpinstaller.cf/5b01a783-a15f-4aa3-a534-36cc79988fe3?amount=1"),true)['value'];

$version = file_get_contents("https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/version.txt");

echo "Welcome to PMMPInstaller by tpguy825!\n\nYou are using version $version.\n\n"; 
$api = json_decode(file_get_contents("https://update.pmmp.io/api"),true);
$url = $api['download_url'];
$lessurl = "https://github.com/pmmp/PocketMine-MP/releases/download/".$api['base_version']."/";

echo "\nDownloading latest PMMP version (".$api['base_version'].") for MC version (".$api['mcpe_version'].") ";

copy($url, "PocketMine-MP.phar");
copy($lessurl."start.cmd", "start.cmd");
copy($lessurl."start.ps1", "start.ps1");
copy($lessurl."start.sh", "start.sh");

echo "Success! You can now delete 'installer.php'";
unlink('installer.php');
