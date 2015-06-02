<?php
return array(
	'www'=>array(
		'documentRoot'=>SF_WWW_URL,//绑定域名
		'fileDIR'=>'/home/www/upload/www/',		   //文件位置
		'folderType'=>array(
				'1'=>array(
					'fileType'=>array('text/html'),
					'folderName'=>'tpl',
				),
				'2'=>array(
					'fileType'=>array('application/zip'),
					'folderName'=>'zt',
				),
			),
	),
	
	'zt'=>array(
		'documentRoot'=>$_SERVER['P_URL'],//绑定域名
		'fileDIR'=>'/home/www/html/',//文件位置
		'folderType'=>array(
			'1'=>array(
				'fileType'=>array('application/zip'),
				'folderName'=>'zt',
			),
			'2'=>array(
				'fileType'=>array('application/x-zip-compressed'),
				'folderName'=>'zt',
			),
		),
	),
	
	'gold'=>array(
		'documentRoot'=>$_SERVER['P_URL'].'/gold',//绑定域名
		'fileDIR'=>'/home/www/upload/pimg/gold',		//文件位置
		'folderType'=>array(
			'1'=>array(
				'fileType'=>array('text/css'),
				'folderName'=>'css',
			),
			'2'=>array(
				'fileType'=>array('image/jpg','image/jepg','image/gif','image/png'),
				'folderName'=>'images',
			),
			'3'=>array(
				'fileType'=>array('application/x-shockwave-flash'),
				'folderName'=>'flash',
			),
			'4'=>array(
				'fileType'=>array('application/x-js'),
				'folderName'=>'js',
			),
		),
	),
	'images'=>array(
		'documentRoot'=>$_SERVER['P_URL'],//商品图片绑定域名
		'fileDIR'=>'/home/www/upload/pimg/'	   //商品图片文件位置
	),
	'pic'=>array(
		'documentRoot'=>$_SERVER['PIC_URL'].'/',//商品图片绑定域名
		'fileDIR'=>'/home/www/pic/'	   //商品图片文件位置
	),
	
	'memcacheVersion'=>"20120922",//memcache 存储版本号	
	'adminEmail' => 'cs@sfbest.cn',	
	'hessianUrl' => 'http://10.103.20.14:8080/search/remoteSearcher.hessian', //Hessian服务地址
	'openSearchEngineSync' => true,	//是否开启搜索同步：正式环境请开启
	'wmsCompany' => '58773096-8', //WMS分配给优选的货主值
);