# PMMPInstaller
Automatic installer for PocketMine-MP

To use it, just run this command (replacing php with a custom binary if needed):
```bat
php -r "$url = 'https://github.com/tpguy825/PMMPInstaller/blob/main/installer.php'; copy($url,'installer.php'); if(hash_file('sha256', 'installer.php') == hash_file('sha256', $url)) { echo 'Your file is valid!'; } else { die('Invalid file, please try again'); }" && php installer.php && php -r "unlink('installer.php');"
```
