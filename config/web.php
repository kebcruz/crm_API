<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'es-Es',
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
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',
            'on afterLogin' => function ($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
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
                ['class' => 'yii\web\UrlRule', 'pattern' => 'permisos/user/<text:.*>', 'route' => 'permiso/user'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'permiso',
                    'tokens' => [
                        '{id}'  => '<id:\\d[\\d,]*>',
                        '{rol}' => '<rol:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET lista-permisos/{rol}' => 'lista-permisos/{rol}'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'archivos/upload/<text:.*>', 'route' => 'archivo/upload'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'archivos/buscar/<text:.*>', 'route' => 'archivo/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'archivos/total/<text:.*>', 'route' => 'archivo/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'archivo',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total',
                        'POST upload' => 'upload',
                    ],
                ],
                
                ['class' => 'yii\web\UrlRule', 'pattern' => 'categorias/buscar/<text:.*>', 'route' => 'categoria/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'categorias/total/<text:.*>', 'route' => 'categoria/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'categoria',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total',
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'empleados/buscar/<text:.*>', 'route' => 'empleado/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'empleados/total/<text:.*>', 'route' => 'empleado/total'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'empleado',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total',
                        'POST login'     => 'login',
                        'POST registrar' => 'registrar',
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'productos/buscar/<text:.*>', 'route' => 'producto/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'productos/total/<text:.*>', 'route' => 'producto/total'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'producto',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'ventas/buscar/<text:.*>', 'route' => 'venta/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'ventas/total/<text:.*>', 'route' => 'venta/total'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'venta',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total'
                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'puesto'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'pais'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'estado'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'archivo'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'categoria'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'clientes/buscar/<text:.*>', 'route' => 'cliente/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'clientes/total/<text:.*>', 'route' => 'cliente/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'cliente',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total',
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'cliente-etiquetas/buscar/<text:.*>', 'route' => 'cliente-etiqueta/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'cliente-etiquetas/total/<text:.*>', 'route' => 'cliente-etiqueta/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'cliente-etiqueta',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total/{text}'  => 'total',
                    ],
                ],
                
                ['class' => 'yii\rest\UrlRule', 'controller' => 'color'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'devolucion'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'domicilio'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'estatu'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'etiqueta'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'metodo'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'municipio'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'pago'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'proveedor'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'venta-detalle'],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'producto-etiqueta'],
            ],
        ],

    ],
    'params' => $params,
    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',

            // 'enableRegistration' => true,

            // Add regexp validation to passwords. Default pattern does not restrict user and can enter any set of characters.
            // The example below allows user to enter :
            // any set of characters
            // (?=\S{8,}): of at least length 8
            // (?=\S*[a-z]): containing at least one lowercase letter
            // (?=\S*[A-Z]): and at least one uppercase letter
            // (?=\S*[\d]): and at least one number
            // $: anchored to the end of the string

            //'passwordRegexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$',


            // Here you can set your handler to change layout for any controller or action
            // Tip: you can use this event in any module
            'on beforeAction' => function (yii\base\ActionEvent $event) {
                if ($event->action->uniqueId == 'user-management/auth/login') {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            },
        ],
    ],
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
