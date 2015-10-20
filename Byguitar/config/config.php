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

        'urlManager' => array(
        'showScriptName' => true,//这里是隐藏index.php那个路径的
        'urlFormat' => 'path',
        'rules' => array(
            '<controller:\w+>/<id:\d+>' => '<controller>/index',
            '<controller:\w+>/<id:\d+>-<brand:\d+>-<price:\d+>-<size:\d+>-<origin:\d+>-<color:\d+>-<sort:\d+>' => '<controller>/index',
            '<controller:\w+>/<id:\d+>-<brand:\d+>-<price:\d+>-<size:\d+>-<origin:\d+>-<color:\d+>-<sort:\d+>-<p:\d+>' => '<controller>/index',
            
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            )
        ),
   
//        array('/^shop\/category\/(\d+)$/','Shop/category/index','cat'),
//        array('/^shop\/category\/(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/','Shop/category/index','cat,brand,price,size,origin,color,sort'),
//        array('/^shop\/category\/(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/','Shop/category/index','cat,brand,price,size,origin,color,sort,p'),	
//
//        array('/^shop\/item\/(\d+)$/','Shop/item/index','id'),
//        array('/^shop\/order\/(BG\d+)$/','Shop/cart/finish','ordersn'),
//        array('/^shop\/pay\/(BG\d+)$/','shop/pay/redirectAlipay','ordersn'),
//        array('/^shop\/pay\/alipay\/(BG\d+)$/','shop/pay/alipay','ordersn'),
//
//        array('/^api\/zine\/index\/(\d+)\/page\/(\d+)$/','Api/zine/index','type,p'),
//        array('/^api\/zine\/comments\/(\d+)\/page\/(\d+)$/','Api/zine/comments','id,p'),


        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            //'class' => 'WebUser',
        ),
        // 'db'=>array(
        // 	'connectionString' => 'sqlite:protected/data/blog.db',
        // 	'tablePrefix' => 'tbl_',
        // ),
        // uncomment the following to use a MySQL database

        'db' => array(
            'class'=> 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=test',
            'emulatePrepare' => true,
            'enableParamLogging' => true, // 加入 
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix' => 'bg_',  
        ),
        'byguitar' => array(
            'class'=> 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=byguitar',
            'emulatePrepare' => true,
            'enableParamLogging' => true, // 加入 
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix' => 'bg_',
        ),
        'shop' => array(
            'class'=> 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=byguitar_shop_yii',
            'emulatePrepare' => true,
            'enableParamLogging' => true, // 加入 
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix' => 'bg_',
        ),

        'errorHandler'=>array(
            //'errorAction'=>'index/error',
            'errorAction'=>'site/error',
        ),

        /*'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                    'post/<id:\d+>/<title:.*?>'=>'post/view',
                    'posts/<tag:.*?>'=>'post/index',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),*/
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning,trace',
                ),
                // 以下是新加
//                array( // configuration for the toolbar
//                    'class'=>'XWebDebugRouter',
//                    'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
//                    'levels'=>'error, warning, trace, profile, info',
//                    //'categories' => 'system.db.*',
//                    //'allowedIPs'=>array('127.0.0.1','::1','192\.168\.1[0-5]\.[0-9]{3}','如果程序在外网需要填入你的公网的ip'),
//                  ),
            ),
        ),

    ),


    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>require(dirname(__FILE__).'/params.php'),
);
