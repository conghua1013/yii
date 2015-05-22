<?php

class ShopConfigController extends ManageController {

	//列表页面
	public function actionIndex(){
		$list = ShopConfig::model()->getConfigListPage();
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
			$m = new ShopConfig();
			$m->attribute_name 	= $_POST['attribute_name'];
			$m->attribute 		= $_POST['attribute'];
			$m->value 			= $_POST['value'];
			$m->add_time 		= time();
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
			$info = ShopConfig::model()->findByPk($_REQUEST['id']);
			$viewData = array();
			$viewData['info'] = $info;
			$this->render('edit', $viewData);exit;
		}

		try{
			$m =  ShopConfig::model()->findByPk($_REQUEST['id']);
			$m->attribute_name 	= $_POST['attribute_name'];
			$m->attribute 		= $_POST['attribute'];
			$m->value 			= $_POST['value'];
			$m->add_time 		= time();
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