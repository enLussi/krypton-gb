<?php

use Core\Agora\Dotenv;
use Agora\Autoloader\Autoloader;

require_once "autopath.php";

require_once ABS_PATH . '/src/Models/Autoloader.php';
Autoloader::register();

require_once ABS_PATH . '/vendor/agora/dotenv/Dotenv.php';
(new Dotenv(ABS_PATH . '/.env'))->load();

$agora = require $_SERVER['SCRIPT_FILENAME'];

$agora = $agora(new Setup_config());

exit();

?>