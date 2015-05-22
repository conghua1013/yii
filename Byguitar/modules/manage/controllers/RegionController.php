<?php

class RegionController extends ManageController {

	//列表页面
	public function actionIndex(){
		$list = Region::model()->getRegionListPage();
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
			$level = 1;
			if($_POST['parent_id']){
				$info = Region::model()->findByPk($_POST['parent_id']);
				if(empty($info)){
					throw new exception('父级id不存在！');
				}
				$level = $info['level']+1;
			}
			$m = new Region();
			$m->region_name = $_POST['region_name'];
			$m->area_code 	= $_POST['area_code'];
			$m->is_show 	= $_POST['is_show'];
			$m->level 		= $level;
			$m->parent_id 	= $_POST['parent_id'];
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
			$info = Region::model()->findByPk($_REQUEST['id']);
			$viewData = array();
			$viewData['info'] = $info;
			$this->render('edit', $viewData);exit;
		}

		try{
			$m =  Region::model()->findByPk($_REQUEST['id']);
			
			$level = 1;
			if($_POST['parent_id']){
				$info = Region::model()->findByPk($_POST['parent_id']);
				if(empty($info)){
					throw new exception('父级id不存在！');
				}
				$level = $info['level']+1;
			}
			$m->region_name = $_POST['region_name'];
			$m->area_code 	= $_POST['area_code'];
			$m->is_show 	= $_POST['is_show'];
			$m->level 		= $level;
			$m->parent_id 	= $_POST['parent_id'];
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

	public function actionDel(){
		try{
			if(empty($_REQUEST['id'])){
				throw new Exception("数据错误，id不能为空！", 1);
			}
			$flag = Region::model()->deleteByPk($_REQUEST['id']);
			if($flag){
				$message = '删除成功!';
				$status = 200;
			}else{
				$message = '删除失败!';
				$status = 300;
			}
		}catch(Exception $e){
			$message = $e->getMessage();
			$status = 300;
		}

		$res = array();
		$res['statusCode'] 		= $status;
		$res['message'] 		= $message;
		$this->ajaxDwzReturn($res);
	}

}