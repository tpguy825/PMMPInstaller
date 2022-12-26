<?php
unlink(__FILE__);
// echo "\n";
$api = json_decode(file_get_contents("https://update.pmmp.io/api"), true);
$phpversion = $api['php_version'];
if(phpversion() < $phpversion) {
    die("[PMMPInstaller] \x1B[31mError:\033[0m Your PHP version (".phpversion().") is outdated and cannot run the latest version of PocketMine-MP. Please upgrade your PHP to at least $phpversion to continue");
}

function isnewer(string $older, string $newer): bool {
	$olderarray = explode(".", $older);
	$newerarray = explode(".", $newer);
	foreach($olderarray as $key => $value) {
		if($newerarray[$key] > $value) {
			return true;
		}
	}
	return false;
}

// dev mode, activate by adding "dev" to the end of the command
// dev mode ignores the counter
if(isset($argv[1]) && $argv[1] === "dev") {
 	$dltimes = "null";
 	echo "\n\x1B[94mDev mode activated\033[0m\n";
} elseif(isset($argv[1]) && $argv[1] === "startfile") {

    if(file_exists(".failed")) {
        if(file_get_contents(".failed")) {
            unlink('.failed');
            die();
        }
    }

    $oldversion = file_get_contents(".version");
    $newversion = $api['base_version'];
    if(isnewer($oldversion, $newversion)) {
        $url = $api['download_url'];
        unlink('PocketMine-MP.phar');
        copy($url, "PocketMine-MP.phar");
        file_put_contents(".version", $newversion);
        echo "[PMMPInstaller] \x1B[32mUpdated from version $oldversion to $newversion\033[0m\n";
        die();
    } else {
        die("[PMMPInstaller] \x1B[32mAutoUpdate: You're up to date!\033[0m\n");
    }
}

$url = $api['download_url'];
$giturl = "https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/";
    
if(file_exists(".version")) { 
    if(isnewer(file_get_contents(".version"), $api['base_version'])) {
        echo "[PMMPInstaller] Updating...";
        copy($url, "PocketMine-MP.phar");
        copy($giturl."start.cmd", "start.cmd");
        copy($giturl."start.ps1", "start.ps1");
        copy($giturl."start.sh", "start.sh");
        file_put_contents(".version", $api['base_version']);
        echo "\n[PMMPInstaller] \x1B[32mUpdated to the latest version\033[0m";
        exit();                 
    } else {
        die("[PMMPInstaller] \x1B[31mError:\033[0m You are already up to date!\n[PMMPInstaller] If you do not have an install here try deleting '.version'");
    }
}

function input($prompt = null, $length = 1024){
    if($prompt !== null){
        echo $prompt;
    }
    $fp = fopen("php://stdin","r");
    $line = @rtrim(fgets($fp, $length));
    return $line;
}

// Increase download count by 1
if(!isset($dltimes)) { $dltimes = json_decode(file_get_contents("https://api.countapi.xyz/update/pmmpinstaller.cf/5b01a783-a15f-4aa3-a534-36cc79988fe3?amount=1"),true)['value']; }

$installerversion = json_decode(file_get_contents("https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/version.json"), true)['version'];
echo "Welcome to \x1B[35mPMMPInstaller\033[0m by \x1B[35mtpguy825\033[0m!\n\nYou are using version \x1B[36m$installerversion\033[0m.\n"; 
echo "Downloading latest PMMP version (\x1B[36m".$api['base_version']."\033[0m) for MC version (\x1B[36m".$api['mcpe_version']."\033[0m)\n\n";
$autoupdate = input("Would you like to enable the AutoUpdate feature? This keeps your PMMP phar up to date (Y/n): ");
copy($url, "PocketMine-MP.phar");
file_put_contents(".version", $api['base_version']);

if($autoupdate === "n") {
    copy($giturl."noautoupdate/start.cmd", "start.cmd");
    copy($giturl."noautoupdate/start.ps1", "start.ps1");
    copy($giturl."noautoupdate/start.sh", "start.sh");
} else {
    copy($giturl."start.cmd", "start.cmd");
    copy($giturl."start.ps1", "start.ps1");
    copy($giturl."start.sh", "start.sh");
}

exit("\x1B[32mDone! Run start.cmd, start.sh or start.ps1 to continue.\033[0m");
