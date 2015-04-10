<?php

class ProductController extends ManageController {

    public function actionIndex(){
    	$viewData = array();
		$list = Product::model()->getProductList();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $list['pageNum'];
		$this->render('index', $viewData);
    }
    
    public function actionAdd(){
        $viewData = array();
        $this->render('add',$viewData);
    } 
}
