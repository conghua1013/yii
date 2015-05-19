<?php

class ShopConfigController extends ManageController {

	//列表页面
	public function actionIndex(){
		$list = ShopConfig::model()->getOrderListPage();
		$viewData = array();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $list['pageNum'];
		$this->render('index', $viewData);
	}


}