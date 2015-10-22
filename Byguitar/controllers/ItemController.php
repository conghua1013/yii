<?php

class ItemController extends ShopBaseController 
{

	public function actionIndex(){
        $product_id = intval($_REQUEST['id']);
        $pInfo = Product::model()->getProductInfoById($product_id);
        $brandInfo = Brand::model()->findByPk($pInfo['brand_id']);
        if(empty($info)){
            $this->redirect('/');//跳转到首页
        }
        echo "<pre>";
        print_r($info);exit;


        $viewData = array();
        $viewData['pInfo']      = $pInfo;
        $viewData['brandInfo']  = $brandInfo;
		$this->render('item/index',array());
	}
}