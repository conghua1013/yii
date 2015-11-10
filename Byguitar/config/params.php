<?php

return array(
    'Rpc_Service' => array(
	'shop' => array(
            'uri'    => array('tcp://127.0.0.1:2016','tcp://127.0.0.1:2016'),
            'user'   => 'manage',
            'secrect'=> '*#test*#',
        ),
        'test' => array(
            'uri'    => array('tcp://127.0.0.1:2015','tcp://127.0.0.1:2015'),
            'user'   => 'manage',
            'secrect'=> '*#test*#',
        ),
    ),

    'image' => array(
        'product' => array(
            'sizes' => array(50,120,300,600,800),
            'path' => '/www/www/yii/Byguitar/images/product/',
            'types' => array('jpg','gif','png','jpeg'),
        ),
        'brand' => array(
            'path' => '/www/www/yii/Byguitar/images/brand/',
            'types' => array('jpg','gif','png','jpeg'),
        ),
        'banner' => array(
            'path' => '/www/www/yii/Byguitar/images/banner/',
            'types' => array('jpg','gif','png','jpeg'),
        ),
        'bank' => array(
            'path' => '/www/www/yii/Byguitar/images/bank/',
            'types' => array('jpg','gif','png','jpeg'),
        ),
        'module_banner' => array(
            'path' => '/www/www/yii/Byguitar/images/module_banner/',
            'types' => array('jpg','gif','png','jpeg'),
        ),
    ),
    
    'url' => array(
        'web_url' => 'http://mwq.yii.com',
    )
);
