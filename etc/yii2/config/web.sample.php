<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'defaultRoute' => 'home/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'idv2014',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Admin',
            'enableAutoLogin' => true,
        ],
        'customer' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Customer',
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'backend' => 'backend/login',
                'backend/logout' => 'backend/login/logout',
                'backend/profile' => 'backend/login/profile',
                'customer' => 'customer/login',
                'customer/logout' => 'customer/login/logout',
				'browse/subject/<id>/<name>' => 'browse/subject',
				'browse/author/<author>' => 'browse/author',
				'browse/publisher/<publisher>' => 'browse/publisher',
				'book/<id>/<title>' => 'book/detail',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'less' => ['css', '/usr/local/bin/lessc {from} {to} --no-color'], //for mac
                    'ts' => ['js', 'tsc --out {to} {from}'],
                ],
            ],
        ],
        'formatter' => [
            'datetimeFormat' => 'd M Y',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => '$',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'smtp.mailgun.org',
                'port' => '587',
                'username' => 'indonesiabookvendor@mg.dnartworks.co.id',
                'password' => 'ask-manager',
            ],
        ],
		'view' => [
			'theme' => [
				"class" => "\yii\base\Theme",
				"pathMap" => [
					"@app/views" => "@app/themes/ibv"
				], 
				"baseUrl" => "@web/themes/ibv",
			],
		],
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV3' => 'ask-manager',
            'secretV3' => 'ask-manager',
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
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'admin-lte-crud' => '@app/giitemplate/crud/admin-lte',
                ]
            ]
        ]
    ];
}

return $config;
