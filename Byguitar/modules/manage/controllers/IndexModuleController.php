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
    public function actionAdd()
    {
        if(empty($_POST)){
            $types = IndexModule::model()->getType('','array');
            $viewData = array();
            $viewData['types'] = $types;
            $this->render('add', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
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
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'indexModuleList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/indexModule/index';
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionEdit()
    {
        if(empty($_POST)){
            $info = IndexModule::model()->findByPk($_REQUEST['id']);
            $types = IndexModule::model()->getType('','array');
            $viewData = array();
            $viewData['info'] = $info;
            $viewData['types'] = $types;
            $this->render('edit', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
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

            //todo 删除原图片
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'indexModuleList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/indexModule/index';
        $this->ajaxDwzReturn($res);
    }

    //删除页面
    public function actionDel()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $flag = IndexModule::model()->deleteByPk($_REQUEST['id']);
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/indexModule/index';
        $this->ajaxDwzReturn($res);
    }

    //修改状态
    public function actionChange()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
        try{
            $info = IndexModule::model()->findByPk($_REQUEST['id']);
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
            $res['statusCode'] = 300;
            $res['message'] = '修改失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/indexModule/index';
        $this->ajaxDwzReturn($res);
    }

}