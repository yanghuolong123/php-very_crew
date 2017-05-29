<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'timeZone' => 'PRC',
    'defaultRoute' => 'home',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'a8lSsRqjuIKp6p77MsnefGrG11qQTC0W',
            //'enableCsrfValidation' => false,
        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
            
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'smtp.163.com',
              'username' => 'yhl27ml@163.com',
              'password' => 'yanghuolong123',
              'port' => '465',
              'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => require(__DIR__.'/memcache.php'),
        'db' => require(__DIR__ . '/db.php'),
        'mongodb' => require(__DIR__.'/mongodb.php'),
        'redis' => require(__DIR__ . '/redis.php'),
         
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'common' => 'common.php', //可以加多个，是yii::t里面的第一个参数名
                    ],
                    //'basePath' => '/messages', //配置语言文件路径，现在采用默认的，就可以不配置这个
                ],
                'yii' => [ 
                    'class' => 'yii\i18n\PhpMessageSource', 
//                    'sourceLanguage' => 'zh-CN', 
//                    'basePath' => '@app/messages',
//                    'fileMap' => [
//                        'yii' => 'yii.php',
//                    ],
                ],
            ],
        ],
         
    ],
    'params' => $params,
    'modules' => [
        'weixin' => [
            'class' => 'app\modules\weixin\WeixinModule',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
