<?php

class ShippingController extends ManageController {

	//列表页面
	public function actionIndex(){
		$list = Shipping::model()->getShippingListPage();
		$viewData = array();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $list['pageNum'];
		$this->render('index', $viewData);
	}

	public function actionAdd(){
		if(empty($_POST)){
			$viewData = array();
			$this->render('add', $viewData);exit;
		}

		try{
			$m = new Shipping();
			$m->shipping_name = $_POST['shipping_name'];
			$m->shipping_fee 	= $_POST['shipping_fee'];
			$m->shipping_code = $_POST['shipping_code'];
			$m->is_show 		= $_POST['is_show'];
			$m->detail 		= $_POST['detail'];
			$flag = $m->save();
			if($flag){
				$message = '添加成功!';
				$status = 200;
			}else{
				$message = '添加失败!';
				$status = 300;
			}
		} catch(Exception $e){
			$message = $e->getMessage();
			$status = 300;
		}

		$res = array();
		$res['statusCode'] 		= $status;
		$res['message'] 		= $message;
		$this->ajaxDwzReturn($res);
	}

	public function actionEdit(){
		if(empty($_POST)){
			$info = Shipping::model()->findByPk($_REQUEST['id']);
			$viewData = array();
			$viewData['info'] = $info;
			$this->render('edit', $viewData);exit;
		}

		try{
			$m =  Shipping::model()->findByPk($_REQUEST['id']);
			$m->shipping_name = $_POST['shipping_name'];
			$m->shipping_fee 	= $_POST['shipping_fee'];
			$m->shipping_code = $_POST['shipping_code'];
			$m->is_show 		= $_POST['is_show'];
			$m->detail 		= $_POST['detail'];
			$flag = $m->save();
			if($flag){
				$message = '修改成功!';
				$status = 200;
			}else{
				$message = '修改失败!';
				$status = 300;
			}
		} catch(Exception $e){
			$message = $e->getMessage();
			$status = 300;
		}

		$res = array();
		$res['statusCode'] 		= $status;
		$res['message'] 		= $message;
		$this->ajaxDwzReturn($res);
	}


}