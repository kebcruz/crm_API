<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wXnIOW3LUI6iMroYI2UWFhsKy2kBEK0Q',
            'parsers' => ['application/json' => 'yii\web\JsonParser',]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'empleado'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'puesto'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'pais'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'estado'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'archivo'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'categoria'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'cliente'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'color'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'devolucion'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'domicilio'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'estatu'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'etiqueta'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'metodo'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'municipio'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'pago'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'producto'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'proveedor'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'venta'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'venta-detalle'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'cliente-etiqueta'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'producto-etiqueta'],
            ],
        ],

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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
