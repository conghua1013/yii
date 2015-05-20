<?php

class OrderController extends ManageController {

	//列表页面
	public function actionIndex(){
		$list = Order::model()->getOrderListPage();
		$viewData = array();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $list['pageNum'];
		$this->render('index', $viewData);
	}

	public function actionInfo(){
		$oInfo = Order::model()->getOrderInfo($_REQUEST['id']);
		$opList = OrderProduct::model()->findAllByAttributes(array('order_id'=>$_REQUEST['id']));
		$oLog = OrderLog::model()->findAllByAttributes(array('order_id'=>$_REQUEST['id']));
		$oShipping = OrderShipping::model()->findAllByAttributes(array('order_id'=>$_REQUEST['id']));
		$viewData = array();
		$viewData['oInfo'] = $oInfo;
		$viewData['opList'] = $opList;
		$viewData['oLog'] = $oLog;
		$viewData['oShipping'] = $oShipping;
		$this->render('info', $viewData);
	}


}