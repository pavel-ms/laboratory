<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cookie-key-validation-aE4-Z_vD3H',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],
        ],

		'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

		'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],

		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'rules' => [
				'<_c:(login|chat)>' => '/',  // пока такой костыль, чтобы не возвращалась 404
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				'<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
				'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>'
			],
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

		'redis' => [
			'class' => 'yii\redis\Connection',
			'hostname' => 'localhost',
			'port' => 6379,
			'database' => 0,
		],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'allowedIPs' => [$_SERVER['REMOTE_ADDR']],
	];
}

return $config;
