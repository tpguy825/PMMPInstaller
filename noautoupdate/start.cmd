@echo off
TITLE PocketMine-MP server software for Minecraft: Bedrock Edition
cd /d %~dp0

set PHP_BINARY=

REM This is for the PMMPInstaller AutoInstaller feature. To turn it on, set it to 'true'
set AutoUpdater=false

where /q php.exe
if %ERRORLEVEL%==0 (
	set PHP_BINARY=php
)

if exist bin\php\php.exe (
	rem always use the local PHP binary if it exists
	set PHPRC=""
	set PHP_BINARY=bin\php\php.exe
)

if "%PHP_BINARY%"=="" (
	echo Couldn't find a PHP binary in system PATH or "%~dp0bin\php"
	echo Please refer to the installation instructions at https://doc.pmmp.io/en/rtfd/installation.html
	pause
	exit 1
)

if exist PocketMine-MP.phar (
	set POCKETMINE_FILE=PocketMine-MP.phar
) else (
	echo PocketMine-MP.phar not found
	echo Downloads can be found at https://github.com/pmmp/PocketMine-MP/releases
	pause
	exit 1
)

if %AutoUpdater% == true (
	%PHP_BINARY% -r "function geturl() { return 'https://pmmpinstaller.cf/installer.php'; } function getfile() { copy(geturl(),'installer.php'); } getfile(); if(hash_file('sha256', 'installer.php') !== hash_file('sha256', geturl())) { invalidfile(); } function invalidfile() { echo '[PMMPInstaller] Note: AutoUpdate tried to check for updates but failed. Trying again...'; getfile(); if(hash_file('sha256', 'installer.php') !== hash_file('sha256', geturl())) { file_put_contents('.failed', true); die('[PMMPInstaller] Error: AutoUpdate tried to update after failing, and failed again. Try re-running the PMMPInstaller command found at https://pmmpinstaller.cf to fix it'); } }" %AutoUpdater% && %PHP_BINARY% installer.php startfile
)

if exist bin\mintty.exe (
	start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o Font="Consolas" -o FontHeight=10 -o CursorType=0 -o CursorBlinks=1 -h error -t "PocketMine-MP" -i bin/pocketmine.ico -w max %PHP_BINARY% %POCKETMINE_FILE% --enable-ansi %*
) else (
	REM pause on exitcode != 0 so the user can see what went wrong
	%PHP_BINARY% %POCKETMINE_FILE% %* || pause
)
