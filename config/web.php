<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zCVnffS2p43LD_DU4On7htCNjuOy-uBa',
            'parsers' => [
                'text/xml' => 'light\yii2\XmlParser',
                'application/xml' => 'light\yii2\XmlParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'johnitvn\userplus\basic\models\UserAccounts',
            'loginUrl'=>'/user/security/login'
        ],
        'rbac' => [
            'class' => 'yii\rbac\Rule',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],

    ],
    'modules' => [
        'user'=>[
            'class'=>'johnitvn\userplus\basic\Module',
            // You can add other config after
        ],
        'rbac' =>  [
            'class' => 'johnitvn\rbacplus\Module',
            'userModelClassName'=>null,
            'userModelIdField'=>'id',
            'userModelLoginField'=>'username',
            'userModelLoginFieldLabel'=>null,
            'userModelExtraDataColumls'=>null,
            'beforeCreateController'=>null,
            'beforeAction'=>null
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '172.17.0.1'],
    ];
}

return $config;
