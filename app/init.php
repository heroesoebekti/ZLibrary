<?php
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/config.php';
require_once '../vendor/autoload.php';
require_once '../app/Helpers/Gettext.php';

//\App\Helpers\Gettext::init(APP_LANG);
