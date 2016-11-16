<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',            
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'smtp.163.com',
              'username' => 'yhl27ml@163.com',
              'password' => 'yanghuolong123',
              'port' => '465',
              'encryption' => 'ssl',
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'scriptUrl' => 'http://my.feichangjuzu.com/index.php',
        ],
        'db' => $db,
        'redis' => require(__DIR__ . '/redis.php'),
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
