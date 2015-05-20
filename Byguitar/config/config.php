<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	// 'baseUrl'=>'mwq.yii.com',
	'name'=>'byguitar Demo',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.manage.components.*',
		'application.modules.manage.models.*',
	),

	'modules' => array(
		'manage'=>array(),
	),

	'defaultController'=>'index',

	// application components
	'components'=>array(
		'baseUrl'=>'mwq.yii.com',
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:protected/data/blog.db',
		// 	'tablePrefix' => 'tbl_',
		// ),
		// uncomment the following to use a MySQL database
		
		'db' => array(
			'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=test',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			// 'tablePrefix' => 'tbl_',
		),
		'byguitar' => array(
			'class'=> 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=byguitar',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'tablePrefix' => 'bg_',
		),
		'shop' => array(
			'class'=> 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=byguitar_shop_yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'tablePrefix' => 'bg_',
		),
		
		'errorHandler'=>array(
			//'errorAction'=>'index/error',
			'errorAction'=>'site/error',
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	// 'params'=>require(dirname(__FILE__).'/params.php'),
);
