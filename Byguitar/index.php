<?php
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ROOT_PATH',dirname(__FILE__));

/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/config/config.php';

//自动加载lib库
require ROOT_PATH.'/lib/Bootstrap/Autoloader.php';
\Bootstrap\Autoloader::instance()->addRoot(ROOT_PATH.'/lib/')->init();

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
