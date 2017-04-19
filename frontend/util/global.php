<?php

date_default_timezone_set('PRC');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
defined('TIMESTAMP') or define('TIMESTAMP', $_SERVER['REQUEST_TIME']);
defined('DATETIME') or define('DATETIME', date('Y-m-d H:i:s', TIMESTAMP));

