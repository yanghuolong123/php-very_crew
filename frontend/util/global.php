<?php

date_default_timezone_set('PRC');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
defined('TIMESTAMP') or define('TIMESTAMP', $_SERVER['REQUEST_TIME']);
defined('DATETIME') or define('DATETIME', date('Y-m-d H:i:s', TIMESTAMP));
defined('DATE') or define('DATE', date('Y-m-d', TIMESTAMP));

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$currentUrl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

defined('CURRENTURL') or define('CURRENTURL', $currentUrl);