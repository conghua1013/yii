<?php

class BannerController extends ManageController {

    //列表页面
    public function actionIndex()
    {
        $list = Banner::model()->getBannerListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $viewData['request'] = $_REQUEST;
        $this->render('index', $viewData);
    }

    //添加页面
    public function actionAdd()
    {
        if(empty($_POST)){
            $stations = Banner::model()->getBannertSation();
            $viewData = array();
            $viewData['stations'] = $stations;
            $this->render('add', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
        try {
            $banner_name = '';
            $image = CUploadedFile::getInstanceByName('banner_image');
            if($image){
                $dir = Yii::getPathOfAlias('webroot').'/images/banner';
                // $extension = substr(strrchr($image->name, '.'), 1);
                $extension = $image->getExtensionName();
                $banner_name = time().'_'.rand(100,999).'.'.$extension;
                $imagePath = $dir.'/'.$banner_name;
                $image->saveAs($imagePath,true);
            }

            $m = new Banner();
            $m->title 		     = $_REQUEST['title'];
            $m->station         = $_REQUEST['station'];
            $m->img             = $banner_name;
            $m->link 		     = $_REQUEST['link'];
            $m->sort 		     = $_REQUEST['sort'];
            $m->is_show 		 = $_REQUEST['is_show'];
            $m->start_time 	 = strtotime( $_REQUEST['start_time']);
            $m->end_time 		 = strtotime($_REQUEST['end_time']);
            $m->add_time 		 = time();
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'bannerList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/banner/index';
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Banner::model()->findByPk($_REQUEST['id']);
            $stations = Banner::model()->getBannertSation();
            $viewData = array();
            $viewData['info'] = $info;
            $viewData['stations'] = $stations;
            $this->render('edit', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try {
            $banner_name = '';
            $image = CUploadedFile::getInstanceByName('banner_image');
            if($image){
                $dir = Yii::getPathOfAlias('webroot').'/images/banner';
                // $extension = substr(strrchr($image->name, '.'), 1);
                $extension = $image->getExtensionName();
                $banner_name = time().'_'.$_REQUEST['id'].'.'.$extension;
                $imagePath = $dir.'/'.$banner_name;
                $image->saveAs($imagePath,true);
            }

            $m =  Banner::model()->findByPk($_REQUEST['id']);
            if($banner_name){
                $m->img             = $banner_name;
            }
            $m->title 		     = $_REQUEST['title'];
            $m->station         = $_REQUEST['station'];
            $m->link 		     = $_REQUEST['link'];
            $m->sort 		     = $_REQUEST['sort'];
            $m->is_show 		 = $_REQUEST['is_show'];
            $m->start_time 	 = strtotime( $_REQUEST['start_time']);
            $m->end_time 		 = strtotime($_REQUEST['end_time']);
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'bannerList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/banner/index';
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
            $flag = Banner::model()->deleteByPk($_REQUEST['id']);
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/banner/index';
        $this->ajaxDwzReturn($res);
    }

    //修改状态
    public function actionChange()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            $info = Banner::model()->findByPk($_REQUEST['id']);
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->is_show = $_REQUEST['is_show'];
            $flag = $info->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch (Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '修改失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/banner/index';
        $this->ajaxDwzReturn($res);
    }

}