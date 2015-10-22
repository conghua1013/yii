<?php

class IndexModuleController extends ManageController {

    //列表页面
    public function actionIndex(){
        $list = IndexModule::model()->getIndexModuleListPage();
        $types = IndexModule::model()->getType('','array');
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $viewData['request'] = $_REQUEST;
        $viewData['types'] = $types;
        $viewData['filter'] = $_REQUEST;
        $this->render('index', $viewData);
    }

    //添加页面
    public function actionAdd(){
        if(empty($_POST)){
            $types = IndexModule::model()->getType('','array');
            $viewData = array();
            $viewData['types'] = $types;
            $this->render('add', $viewData);exit;
        }

        try {
            $banner_name = '';
            $image = CUploadedFile::getInstanceByName('img');
            if($image){
                //$dir = Yii::getPathOfAlias('webroot').'/images/indexmodule';
                $imageConfig = Yii::app()->params['image']['module_banner'];
                $dir = $imageConfig['path'];
                // $extension = substr(strrchr($image->name, '.'), 1);
                $extension = $image->getExtensionName();
                $banner_name = time().'_'.rand(100,999).'.'.$extension;
                $imagePath = $dir.'/'.$banner_name;
                $image->saveAs($imagePath,true);
            }

            $m = new IndexModule();
            $m->title 		 = $_REQUEST['title'];
            $m->link         = $_REQUEST['link'];
            $m->img          = $banner_name;
            $m->describtion  = $_REQUEST['describtion'];
            $m->product_ids  = $_REQUEST['product_ids'];
            $m->type 		 = $_REQUEST['type'];
            $m->sort 		 = $_REQUEST['sort'];
            $m->is_show 	 = $_REQUEST['is_show'];
            $m->start_time 	 = strtotime( $_REQUEST['start_time']);
            $m->end_time 	 = strtotime($_REQUEST['end_time']);
            $m->add_time 	 = time();
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
        $res['statusCode'] 	= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionEdit(){
        if(empty($_POST)){
            $info = IndexModule::model()->findByPk($_REQUEST['id']);
            $types = IndexModule::model()->getType('','array');
            $viewData = array();
            $viewData['info'] = $info;
            $viewData['types'] = $types;
            $this->render('edit', $viewData); exit;
        }

        try {
            $banner_name = '';
            $image = CUploadedFile::getInstanceByName('img');
            if($image){
                //$dir = Yii::getPathOfAlias('webroot').'/images/indexmodule';
                $imageConfig = Yii::app()->params['image']['module_banner'];
                $dir = $imageConfig['path'];
                // $extension = substr(strrchr($image->name, '.'), 1);
                $extension = $image->getExtensionName();
                $banner_name = time().'_'.$_REQUEST['id'].'.'.$extension;
                $imagePath = $dir.'/'.$banner_name;
                $image->saveAs($imagePath,true);
            }

            $m =  IndexModule::model()->findByPk($_REQUEST['id']);
            $m->title 		 = $_REQUEST['title'];
            $m->link         = $_REQUEST['link'];
            if($banner_name){
                $m->img             = $banner_name;
            }
            $m->describtion  = $_REQUEST['describtion'];
            $m->product_ids  = $_REQUEST['product_ids'];
            $m->type 		 = $_REQUEST['type'];
            $m->sort 		 = $_REQUEST['sort'];
            $m->is_show 	 = $_REQUEST['is_show'];
            $m->start_time 	 = strtotime( $_REQUEST['start_time']);
            $m->end_time 	 = strtotime($_REQUEST['end_time']);
            $m->add_time 	 = time();
            $flag = $m->save();
            if($flag){
                //todo 删除原图片

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
        $flag = IndexModule::model()->deleteByPk($_REQUEST['id']);
        if($flag){
            //todo 删除原图片
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
        $info = IndexModule::model()->findByPk($_REQUEST['id']);
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