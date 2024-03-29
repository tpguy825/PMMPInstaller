﻿[CmdletBinding(PositionalBinding=$false)]
param (
	[string]$php = "",
	[switch]$Loop = $false,
	[string]$file = "",
	# Enables PMMPInstaller's AutoUpdater feature. To disable, change $true to $false
	[switch]$AutoUpdater = $true,
	[string][Parameter(ValueFromRemainingArguments)]$extraPocketMineArgs
)

if($php -ne ""){
	$binary = $php
}elseif(Test-Path "bin\php\php.exe"){
	$env:PHPRC = ""
	$binary = "bin\php\php.exe"
}elseif((Get-Command php -ErrorAction SilentlyContinue)){
	$binary = "php"
}else{
	echo "Couldn't find a PHP binary in system PATH or $pwd\bin\php"
	echo "Please refer to the installation instructions at https://doc.pmmp.io/en/rtfd/installation.html"
	pause
	exit 1
}

if($file -eq ""){
	if(Test-Path "PocketMine-MP.phar"){
	    $file = "PocketMine-MP.phar"
	}else{
	    echo "PocketMine-MP.phar not found"
	    echo "Downloads can be found at https://github.com/pmmp/PocketMine-MP/releases"
	    pause
	    exit 1
	}
}

function StartServer{
	$command = "powershell -NoProfile " + $binary + " " + $file + " " + $extraPocketMineArgs
	iex $command
}

if($AutoUpdater -eq $true) {
	$php -r "$url = 'https://pmmpinstaller.cf/installer.php'; copy($url,'installer.php'); if(hash_file('sha256', 'installer.php') == hash_file('sha256', $url)) { echo 'Your file is valid!'; } else { die('Invalid file, please try again'); }" && $php installer.php startfile
}

$loops = 0

StartServer

while($Loop){
	if($loops -ne 0){
		echo ("Restarted " + $loops + " times")
	}
	$loops++
	echo "To escape the loop, press CTRL+C now. Otherwise, wait 5 seconds for the server to restart."
	echo ""
	Start-Sleep 5
	StartServer
}
