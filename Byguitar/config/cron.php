<?php

//require_once('env.php');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Byguitar Console',
    // application components
    'components'=>array(
        //Main DB connection
        // 'db'=>array(
        //     'connectionString'=>DB_CONNECTION,
        //     'username'=>DB_USER,
        //     'password'=>DB_PWD,
        //     'enableParamLogging'=>true,
        // ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),        
    ),

);