<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', getenv('CI_ENVIRONMENT') === 'development');
defined('YII_ENV') or define('YII_ENV', getenv('CI_ENVIRONMENT') === 'development' ? 'dev' : 'prod');
require('../etc/yii2/vendor/autoload.php');
require('../etc/yii2/vendor/yiisoft/yii2/Yii.php');

$config = require('../etc/yii2/config/web.php');

(new yii\web\Application($config))->run();
