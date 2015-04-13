<?php

class BrandController extends ManageController {

	//列表页面
	public function actionIndex(){
		$list = Brand::model()->getBrandListPage();
		$viewData = array();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $list['pageNum'];
		$viewData['request'] = $_REQUEST;
		$this->render('index', $viewData);
	}

	//添加页面
	public function actionAdd(){
		if(empty($_POST)){
			$viewData = array();
			$this->render('add', $viewData);
			exit;
		}

		try {
			$message = '';
			$status = 200;

			$brand_name = '';
			$image = CUploadedFile::getInstanceByName('brand_logo');
			if($image){
				$dir = Yii::getPathOfAlias('webroot').'/images/brand';
				$extension = substr(strrchr($image->name, '.'), 1); 
				$brand_name = time().'_0.'.$extension;
				$imagePath = $dir.'/'.$brand_name;
				$status = $image->saveAs($imagePath,true);
			}
			
			$m = new Brand();
			$m->brand_name 		= $_REQUEST['brand_name'];
			$m->english_name 	= $_REQUEST['english_name'];
			$m->brand_logo 		= $brand_name;
			$m->from_city 		= $_REQUEST['from_city'];
			$m->address 		= $_REQUEST['address'];
			$m->mobile 			= $_REQUEST['mobile'];
			$m->tel 			= $_REQUEST['tel'];
			$m->site_url 		= $_REQUEST['site_url'];
			$m->keywords 		= $_REQUEST['keywords'];
			$m->describtion 	= $_REQUEST['describtion'];
			$m->sort 			= $_REQUEST['sort'];
			$m->is_show 		= $_REQUEST['is_show'];
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

	//编辑页面
	public function actionEdit(){
		if(empty($_POST)){
			$info = Brand::model()->findByPk($_REQUEST['id']);
			$viewData = array();
			$viewData['info'] = $info;
			$this->render('edit', $viewData);
			exit;
		}

		try {
			$message = '';
			$status = 200;

			$brand_name = '';
			$image = CUploadedFile::getInstanceByName('brand_logo');
			if($image){
				$dir = Yii::getPathOfAlias('webroot').'/images/brand';
				$extension = substr(strrchr($image->name, '.'), 1); 
				$brand_name = time().'_'.$_REQUEST['id'].'.'.$extension;
				$imagePath = $dir.'/'.$brand_name;
				$status = $image->saveAs($imagePath,true);
			}
			
			$m =  Brand::model()->findByPk($_REQUEST['id']);
			$m->brand_name 		= $_REQUEST['brand_name'];
			$m->english_name 	= $_REQUEST['english_name'];
			if($brand_name){
				$m->brand_logo 		= $brand_name;
			}
			$m->from_city 		= $_REQUEST['from_city'];
			$m->address 		= $_REQUEST['address'];
			$m->mobile 			= $_REQUEST['mobile'];
			$m->tel 			= $_REQUEST['tel'];
			$m->site_url 		= $_REQUEST['site_url'];
			$m->keywords 		= $_REQUEST['keywords'];
			$m->describtion 	= $_REQUEST['describtion'];
			$m->sort 			= $_REQUEST['sort'];
			$m->is_show 		= $_REQUEST['is_show'];
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

	//删除页面
	public function actionDel(){
		$flag = Brand::model()->deleteByPk($_REQUEST['id']);
		if($flag){
			$message = '删除成功!';
			$status = 200;
		}else{
			$message = '删除失败!';
			$status = 300;
		}
		$res = array();
		$res['statusCode'] 		= $status;
		$res['message'] 		= $message;
		$this->ajaxDwzReturn($res);
	}

	//修改状态
	public function actionChange(){
		$info = Brand::model()->findByPk($_REQUEST['id']);
		try{
			if(empty($info)){
				throw new exception('记录不存在了！');
			}
			$info->is_show = $_REQUEST['is_show'];
			$flag = $info->save();
			if(empty($flag)){
				throw new exception('修改状态失败！');
			}

			$message = '修改状态成功!';
			$status = 200;
		} catch (Exception $e){
			$message = $e->getMessage();
			$status = 300;
		}
		$res = array();
		$res['statusCode'] 		= $status;
		$res['message'] 		= $message;
		$this->ajaxDwzReturn($res);
	}

}