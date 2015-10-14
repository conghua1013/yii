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
            'sizes' => array(100,300,600),
            'path' => '/www/www/yii/Byguitar/images/product/',
            'types' => array('jpg','gif','png','jpeg'),
        ),
        'brand' => array(
            //'sizes' => array(100,300,600),
            'path' => '/www/www/yii/Byguitar/images/brand/',
            'types' => array('jpg','gif','png','jpeg'),
        ),

    )
);
