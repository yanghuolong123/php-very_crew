<?php

$prefix = md5(__DIR__) . '_';
return [
    //'class' => 'yii\redis\Connection',
    'class' => 'app\util\RedisConnection',
    'hostname' => 'localhost',
    'port' => 6379,
    'database' => 0,
    'prefix' => $prefix,
];

