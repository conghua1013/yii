<?php

class SiteController extends CController {

	public function actionError(){
		if($error=Yii::app()->errorHandler->error)
	    {
	    	echo "<pre>";
	    	print_r($error['message']);
	    	echo "<hr>";
	    	print_r($error['trace']);
	    }
	}

    public function actionTest() {
        echo "<pre>";

        // 批量获取是商品详情
        // $product_ids = array(29,30);
        // $list = Product::model()->getProductInfoByIds($product_ids);
        // print_r($list);

        //批量获取数据
        // $list = Product::model()->findAllByAttributes(array('id'=>$product_ids));
        // print_r($list);

        //批量获取商品图片
        // $list = ProductImage::model()->findAllByAttributes(array('product_id'=>$product_ids));
        // $data= array();
        // foreach($list as $row){
        //     $data[$row->product_id][$row->id] = $row->getAttributes();
        // }
        // print_r($data);

        //商品详情
        // $info = Product::model()->getProductInfoById(30);
        // print_r($info);


        exit;
    }
}