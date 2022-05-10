<?php

$api = json_decode(file_get_contents("https://update.pmmp.io/api"),true);
$url = $api['download_url'];
$lessurl = "https://github.com/pmmp/PocketMine-MP/releases/download/".$api['base_version']."/";

echo "\nDownloading latest version (".$api['base_version'].") for MC version (".$api['mcpe_version'].") ";

copy($url, "PocketMine-MP.phar");
copy($lessurl."start.cmd", "start.cmd");
copy($lessurl."start.ps1", "start.ps1");
copy($lessurl."start.sh", "start.sh");

echo "Success! You can now delete 'installer.php'";
unlink('installer.php');
