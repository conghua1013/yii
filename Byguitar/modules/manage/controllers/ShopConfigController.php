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

	public function actionAdd()
	{
		if(empty($_POST)){
			$viewData = array();
			$this->render('add', $viewData);exit;
		}

		$res = array('statusCode' => 200,'message' => '添加成功！');
		try{
			$m = new ShopConfig();
			$m->attribute_name 	= $_POST['attribute_name'];
			$m->attribute 		= $_POST['attribute'];
			$m->value 			= $_POST['value'];
			$m->add_time 		= time();
			$flag = $m->save();
			if(!$flag){
				throw new exception('添加失败');
			}
		} catch(Exception $e){
			$res['statusCode'] = 300;
			$res['message'] = '失败【'.$e->getMessage().'】';
		}
		$res['navTabId'] = 'shopConfigList';
		$res['callbackType'] = 'closeCurrent';
		$res['forwardUrl'] = '/manage/shopConfig/index';
		$this->ajaxDwzReturn($res);
	}

	public function actionEdit(){
		if(empty($_POST)){
			$info = ShopConfig::model()->findByPk($_REQUEST['id']);
			$viewData = array();
			$viewData['info'] = $info;
			$this->render('edit', $viewData);exit;
		}

		$res = array('statusCode' => 200,'message' => '修改成功！');
		try{
			$m =  ShopConfig::model()->findByPk($_REQUEST['id']);
			$m->attribute_name 	= $_POST['attribute_name'];
			$m->attribute 		= $_POST['attribute'];
			$m->value 			= $_POST['value'];
			$m->add_time 		= time();
			$flag = $m->save();
			if(!$flag){
				throw new exception('修改失败');
			}
		} catch(Exception $e){
			$res['statusCode'] = 300;
			$res['message'] = '失败【'.$e->getMessage().'】';
		}
		$res['navTabId'] = 'shopConfigList';
		$res['callbackType'] = 'closeCurrent';
		$res['forwardUrl'] = '/manage/shopConfig/index';
		$this->ajaxDwzReturn($res);
	}

	public function actionDel()
	{
		$res = array('statusCode' => 200,'message' => '删除成功！');
		try{
			if(empty($_REQUEST['id'])){
				throw new Exception("数据错误，id不能为空！", 1);
			}
			$flag = ShopConfig::model()->deleteByPk($_REQUEST['id']);
			if(!$flag){
				throw new exception('删除失败');
			}
		}catch(Exception $e){
			$res['statusCode'] = 300;
			$res['message'] = '删除失败【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/shopConfig/index';
		$this->ajaxDwzReturn($res);
	}

}