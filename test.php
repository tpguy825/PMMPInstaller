<?php

require('../getpmmpversion.php');

if(!isset($argv[1])) {
    die('Missing file');
}

echo getVersion($argv[1]);